<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use App\Models\ProjectProposals;
use App\Models\Reviews\Reviews;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'verify',
        'password',
        'status',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public static function add($request)
    {

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'verify' => $request['verify'],
            'status' => 0
        ]);
        $user->syncRoles( (int)$request['roles'] );

        return $user;
    }


    public static function getByEmail($email)
    {

        $user = User::where('email', $email)
            ->where('status', 1)
            ->first();

        return $user;
    }


    public static function getByVerify($verify)
    {

        $user = User::where('verify', $verify)
            ->first();

        return $user;
    }

    public static function getEmployerCount()
    {
        $employerCount = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('users.status', 1)
            ->where('model_has_roles.role_id', 3)
            ->count();

        return $employerCount;
    }

    public static function getFreelancerCount()
    {
        $freelancerCount = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('users.status', 1)
            ->where('model_has_roles.role_id', 4)
            ->count();

        return $freelancerCount;
    }

    public static function getFreelancer($filter = [])
    {
      
        $user = User::select(
            'users.*',
            'model_has_roles.role_id',
            'user_categories_translations.name as user_category_name',
            'countries_translations.name as user_country_name',
            'countries.image as user_country_image',
            DB::raw("(
                SELECT
                    COUNT(project_hireds.id)
                FROM project_hireds
                WHERE project_hireds.freelancer_id = users.id
            ) as projects_count"),
            DB::raw("(
                SELECT
                    COUNT(reviews.id)
                FROM reviews
                WHERE reviews.to = users.id
            ) as reviews_count"),
            DB::raw("(
                SELECT
                    avg(reviews.rating)
                FROM reviews
                WHERE reviews.to = users.id
            ) as average_rating")
        )
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
//            ->leftJoin('user_categories_translations', 'users.user_category', '=', 'user_categories_translations.user_category_id')
            ->leftJoin('user_categories_translations', function ($join) use ($filter) {
                $join->on('users.user_category', '=', 'user_categories_translations.user_category_id')
                    ->where('user_categories_translations.language_id', '=', $filter['language_id']);
            })
            ->leftJoin('countries', 'users.country', '=', 'countries.id')
            ->leftJoin('countries_translations', function ($join) use ($filter) {
                $join->on('users.country', '=', 'countries_translations.country_id')
                    ->where('countries_translations.language_id', '=', $filter['language_id']);
            })
            ->where('users.status', 1)
            ->where('users.approve', 1)
            ->where('model_has_roles.role_id', 4);


        if (isset($filter['keyword']) && !empty($filter['keyword'])) {
            $user = $user->where('users.name', 'LIKE', "%". stripinput(strip_tags($filter['keyword'])) ."%")
                ->orWhere('users.description', 'LIKE', "%". stripinput(strip_tags($filter['keyword'])) ."%")
                ->where('users.status', 1);
        }
        if (isset($filter['minPrice']) && !empty($filter['minPrice']) && $filter['minPrice'] > 0) {
            $user = $user->where('users.hourly_rate', '>=', (float)$filter['minPrice']);
        }
        if (isset($filter['maxPrice']) && !empty($filter['maxPrice']) && $filter['maxPrice'] > 0) {
            $user = $user->where('users.hourly_rate', '<=', (float)$filter['maxPrice']);
        }
        if (isset($filter['country']) && !empty($filter['country']) && $filter['country'] > 0) {
            $user = $user->where('users.country', (int)$filter['country']);
        }
        if (isset($filter['user_category']) && !empty($filter['user_category']) && $filter['user_category'] > 0) {
            $user = $user->where('users.user_category', (int)$filter['user_category']);
        }

        if (isset($filter['order']) && !empty($filter['order'])) {
            if (isset($filter['sort']) && !empty($filter['sort']) && $filter['sort']=="DESC") {
                $user = $user->orderBy(stripinput($filter['order']), 'DESC');
            } else {
                $user = $user->orderBy(stripinput($filter['order']), 'ASC');
            }

            if (isset($filter['order2']) && !empty($filter['order2'])) {
                if (isset($filter['sort']) && !empty($filter['sort']) && $filter['sort'] == "DESC") {
                    $user = $user->orderBy(stripinput($filter['order2']), 'DESC');
                } else {
                    $user = $user->orderBy(stripinput($filter['order2']), 'ASC');
                }
            }
        } else {
            $user = $user->orderBy('id', 'DESC');
        }

        $user = $user->paginate((isset($filter['limit']) ? (int)$filter['limit'] : 9));

        return $user;
    }

    public static function getFreelancerMinMaxPrice()
    {

        $freelancers = User::select(
            'users.hourly_rate',
        )
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('users.status', 1)
            ->where('model_has_roles.role_id', 4)
            ->get();

        $minPrice = 0;
        $maxPrice = 0;
        foreach ($freelancers as $freelancer) {
            if($freelancer->hourly_rate > $maxPrice)
            {
                $maxPrice = $freelancer->hourly_rate;
            }

            if($freelancer->hourly_rate < $minPrice)
            {
                $minPrice = $freelancer->hourly_rate;
            }
        }

        return [
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ];
    }



    public static function getUser($user_id) {
        $user = User::select(
                'users.*',
                'model_has_roles.role_id'
            )
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('users.id', (int)$user_id)
            ->where('users.status', 1)
            ->first();

        return $user;
    }

    public static function getUserInfo($user_id, $data = []) {
        $user = User::select(
            'users.*',
            'model_has_roles.role_id',
            'user_categories_translations.name as user_category_name',
            'countries_translations.name as user_country_name',
            'countries.image as user_country_image',
            DB::raw("(
                SELECT
                    COUNT(project_hireds.id)
                FROM project_hireds
                WHERE project_hireds.freelancer_id = users.id
            ) as projects_count"),
            DB::raw("(
                SELECT
                    COUNT(reviews.id)
                FROM reviews
                WHERE reviews.to = users.id
            ) as reviews_count"),
            DB::raw("(
                SELECT
                    avg(reviews.rating)
                FROM reviews
                WHERE reviews.to = users.id
            ) as average_rating")
        )
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('user_categories_translations', function ($join) use ($data) {
                $join->on('users.user_category', '=', 'user_categories_translations.user_category_id')
                    ->where('user_categories_translations.language_id', '=', $data['language_id']);
            })
            ->leftJoin('countries', 'users.country', '=', 'countries.id')
            ->leftJoin('countries_translations', function ($join) use ($data) {
                $join->on('users.country', '=', 'countries_translations.country_id')
                    ->where('countries_translations.language_id', '=', $data['language_id']);
            })
            ->where('users.id', (int)$user_id)
            ->where('users.status', 1)
            ->first();

        return $user;
    }

    public static function getParentUser($user_id, $data = []) {
        $user = User::select(
                'users.*',
                'model_has_roles.role_id',
                'user_categories_translations.name as user_category_name',
                'countries_translations.name as user_country_name',
                'countries.image as user_country_image'
            )
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('user_categories_translations', function ($join) use ($data) {
                $join->on('users.user_category', '=', 'user_categories_translations.user_category_id')
                    ->where('user_categories_translations.language_id', '=', $data['language_id']);
            })
            ->leftJoin('countries', 'users.country', '=', 'countries.id')
            ->leftJoin('countries_translations', function ($join) use ($data) {
                $join->on('users.country', '=', 'countries_translations.country_id')
                    ->where('countries_translations.language_id', '=', $data['language_id']);
            })
            ->where('users.id', (int)$user_id)
            ->first();

        return $user;
    }
    public function projectProposals()
    {
        return $this->hasMany(ProjectProposals::class, 'freelancer_id', 'id');
    }

    public function reviews() 
    {
        return $this->hasMany(Reviews::class, 'to', 'id');
    }

   
}

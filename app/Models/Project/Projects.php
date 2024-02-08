<?php

namespace App\Models\Project;

use App\Models\UserCategory\UserCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProjectProposals;
use App\Models\Project\ProjectsCategories;

class Projects extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public static function getProjects($filter = [])
    {
        $projects = Projects::select(
            'projects.*',
            'users.id as user_id',
            'users.name as user_name',
            'users.profile_photo as user_profile_photo',
            'users.social as user_social',
            'user_categories_translations.name as user_category_name',
            'countries_translations.name as user_country_name',
            'countries.image as user_country_image',
            'users.address as user_address',
            'users.postalcode as user_postalcode',
            'users.created_at as user_created_at',
            'project_hireds.id as hired_id',
            'project_hireds.freelancer_id as hired_freelancer_id',
            'project_hireds.project_id as hired_project_id',
            'project_hireds.price as hired_price',
            'project_hireds.hours as hired_hours',
            'project_hireds.letter as hired_letter',
            'project_hireds.status as hired_status',
            'project_hireds.created_at as hired_created_at',
            DB::raw("(
                SELECT user_categories_translations.name
                FROM user_categories_translations
                WHERE user_categories_translations.user_category_id = projects_categories.user_category_id
                LIMIT 1
            ) as user_categories_name")
        )
            ->leftJoin('users', 'projects.employer_id', '=', 'users.id')
            ->leftJoin('user_categories_translations', function ($join) use ($filter) {
                $join->on('users.user_category', '=', 'user_categories_translations.user_category_id')
                    ->where('user_categories_translations.language_id', '=', $filter['language_id']);
            })
            ->leftJoin('projects_categories', 'projects.id', '=', 'projects_categories.project_id')
            ->leftJoin('countries', 'projects.country_id', '=', 'countries.id')
            ->leftJoin('countries_translations', function ($join) use ($filter) {
                $join->on('projects.country_id', '=', 'countries_translations.country_id')
                    ->where('countries_translations.language_id', '=', $filter['language_id']);
            })
            ->leftJoin('project_hireds', 'projects.id', '=', 'project_hireds.project_id');

        if (isset($filter['employer_id']) && $filter['employer_id'] > 0) {
            $projects = $projects->where('projects.employer_id', (int) $filter['employer_id']);
        }

        if (isset($filter['freelancer_id']) && $filter['freelancer_id'] > 0) {
            if (isset($filter['project_hired']) && $filter['project_hired'] == true) {
                $projects = $projects->where('project_hireds.freelancer_id', (int) $filter['freelancer_id']);
            } else {
                $projects = $projects->where('projects.freelancer_id', (int) $filter['freelancer_id']);
            }
        }

        if (isset($filter['status'])) {
            $projects = $projects->where('projects.status', (int) $filter['status']);
        }
        if (isset($filter['approve'])) {
            $projects = $projects->where('projects.approve', (int) $filter['approve']);
        }

        if (isset($filter['keyword']) && !empty($filter['keyword'])) {
            $projects = $projects->where('projects.name', 'LIKE', "%" . stripinput(strip_tags($filter['keyword'])) . "%")
                ->orWhere('projects.description', 'LIKE', "%" . stripinput(strip_tags($filter['keyword'])) . "%");
        }
        if (isset($filter['minPrice']) && !empty($filter['minPrice']) && $filter['minPrice'] > 0) {
            $projects = $projects->where('projects.price', '>=', (float) $filter['minPrice']);
        }
        if (isset($filter['maxPrice']) && !empty($filter['maxPrice']) && $filter['maxPrice'] > 0) {
            $projects = $projects->where('projects.price', '<=', (float) $filter['maxPrice']);
        }
        if (isset($filter['country']) && !empty($filter['country']) && $filter['country'] > 0) {
            $projects = $projects->where('projects.country_id', (int) $filter['country']);
        }
        if (isset($filter['price_type']) && !empty($filter['price_type']) && $filter['price_type'] > 0) {
            $projects = $projects->where('projects.price_type', (int) $filter['price_type']);
        }
        if (isset($filter['project_category']) && !empty($filter['project_category']) && $filter['project_category'] > 0) {
            $projects = $projects->where('projects_categories.user_category_id', (int) $filter['project_category']);
        }
        if (isset($filter['project_hired']) && $filter['project_hired'] == true) {
            $projects = $projects->where('project_hireds.id', '!=', null);
            if (isset($filter['project_hired_status']) && !empty($filter['project_hired_status'])) {
                $projects = $projects->where('project_hireds.status', (int) $filter['project_hired_status']);
            }
        }

        if (isset($filter['search'])) {
            $projects = $projects->where('projects.name', 'like', '%' . $filter['search'] . '%');

        }


        //        $projects = $projects->orderBy('projects.id', 'DESC');
        $projects = $projects->orderBy('projects.updated_at', 'DESC');
        $projects = $projects->groupBy('projects.id');
        $projects = $projects->paginate(isset($filter['limit']) && $filter['limit'] > 0 ? (int) $filter['limit'] :
            9);

        return $projects;
    }



    public static function getTotalProjects($filter = [])
    {
        $projects = Projects::select(
            'projects.*',
            'users.id as user_id',
            'users.name as user_name',
            'users.profile_photo as user_profile_photo',
            'users.social as user_social',
            'user_categories_translations.name as user_category_name',
            'countries_translations.name as user_country_name',
            'countries.image as user_country_image',
            'users.address as user_address',
            'users.postalcode as user_postalcode',
            'users.created_at as user_created_at',
            'project_hireds.id as hired_id',
            'project_hireds.freelancer_id as hired_freelancer_id',
            'project_hireds.project_id as hired_project_id',
            'project_hireds.price as hired_price',
            'project_hireds.hours as hired_hours',
            'project_hireds.letter as hired_letter',
            'project_hireds.status as hired_status',
            'project_hireds.created_at as hired_created_at'
        )
            ->leftJoin('users', 'projects.employer_id', '=', 'users.id')
            ->leftJoin('user_categories_translations', function ($join) use ($filter) {
                $join->on('users.user_category', '=', 'user_categories_translations.user_category_id')
                    ->where('user_categories_translations.language_id', '=', $filter['language_id']);
            })
            ->leftJoin('projects_categories', 'projects.id', '=', 'projects_categories.project_id')
            ->leftJoin('countries', 'projects.country_id', '=', 'countries.id')
            ->leftJoin('countries_translations', function ($join) use ($filter) {
                $join->on('projects.country_id', '=', 'countries_translations.country_id')
                    ->where('countries_translations.language_id', '=', $filter['language_id']);
            })
            ->leftJoin('project_hireds', 'projects.id', '=', 'project_hireds.project_id');

        if (isset($filter['employer_id']) && $filter['employer_id'] > 0) {
            $projects = $projects->where('projects.employer_id', (int) $filter['employer_id']);
        }

        if (isset($filter['freelancer_id']) && $filter['freelancer_id'] > 0) {
            if (isset($filter['project_hired']) && $filter['project_hired'] == true) {
                $projects = $projects->where('project_hireds.freelancer_id', (int) $filter['freelancer_id']);
            } else {
                $projects = $projects->where('projects.freelancer_id', (int) $filter['freelancer_id']);
            }
        }

        if (isset($filter['status'])) {
            $projects = $projects->where('projects.status', (int) $filter['status']);
        }

        if (isset($filter['keyword']) && !empty($filter['keyword'])) {
            $projects = $projects->where('projects.name', 'LIKE', "%" . stripinput(strip_tags($filter['keyword'])) . "%")
                ->orWhere('projects.description', 'LIKE', "%" . stripinput(strip_tags($filter['keyword'])) . "%");
        }
        if (isset($filter['minPrice']) && !empty($filter['minPrice']) && $filter['minPrice'] > 0) {
            $projects = $projects->where('projects.price', '>=', (float) $filter['minPrice']);
        }
        if (isset($filter['maxPrice']) && !empty($filter['maxPrice']) && $filter['maxPrice'] > 0) {
            $projects = $projects->where('projects.price', '<=', (float) $filter['maxPrice']);
        }
        if (isset($filter['country']) && !empty($filter['country']) && $filter['country'] > 0) {
            $projects = $projects->where('projects.country_id', (int) $filter['country']);
        }
        if (isset($filter['price_type']) && !empty($filter['price_type']) && $filter['price_type'] > 0) {
            $projects = $projects->where('projects.price_type', (int) $filter['price_type']);
        }
        if (isset($filter['project_category']) && !empty($filter['project_category']) && $filter['project_category'] > 0) {
            $projects = $projects->where('projects_categories.user_category_id', (int) $filter['project_category']);
        }
        if (isset($filter['project_hired']) && $filter['project_hired'] == true) {
            $projects = $projects->where('project_hireds.id', '!=', null);
            if (isset($filter['project_hired_status']) && !empty($filter['project_hired_status'])) {
                $projects = $projects->where('project_hireds.status', (int) $filter['project_hired_status']);
            }
        }


        $projects = $projects->orderBy('projects.id', 'DESC');
        $projects = $projects->groupBy('projects.id');
        $projects = $projects->get();

        return $projects;
    }


    public static function getTotalProjectsList($filter = [])
    {
        $projects = Projects::select(
            'projects.id',
            'projects.name'
        );

        if (isset($filter['employer_id']) && $filter['employer_id'] > 0) {
            $projects = $projects->where('projects.employer_id', (int) $filter['employer_id']);
        }

        if (isset($filter['status'])) {
            $projects = $projects->where('projects.status', (int) $filter['status']);
        }

        if (isset($filter['keyword']) && !empty($filter['keyword'])) {
            $projects = $projects->where('projects.name', 'LIKE', "%" . stripinput(strip_tags($filter['keyword'])) . "%")
                ->orWhere('projects.description', 'LIKE', "%" . stripinput(strip_tags($filter['keyword'])) . "%");
        }

        $projects = $projects->orderBy('projects.name', 'ASC');
        $projects = $projects->groupBy('projects.id');
        $projects = $projects->get();

        return $projects;
    }

    public static function getProjectsMinMaxPrice($filter = [])
    {
        $projects = Projects::select(
            'projects.price'
        );
        if (isset($filter['status']) && !empty($filter['status'])) {
            $projects = $projects->where('status', (int) $filter['status']);
        }
        if (isset($filter['approve']) && !empty($filter['approve'])) {
            $projects = $projects->where('approve', (int) $filter['approve']);
        }

        $projects = $projects->get();

        $minPrice = 0;
        $maxPrice = 0;
        foreach ($projects as $project) {
            if ($project->price > $maxPrice) {
                $maxPrice = $project->price;
            }

            if ($project->price < $minPrice) {
                $minPrice = $project->price;
            }
        }

        return [
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ];
    }

    public static function getProjectsCount($filter = [])
    {
        $projectsCount = Projects::select(
            'id'
        )
            ->count();

        return $projectsCount;
    }

    public static function getProjectsCountByUserId($user_id)
    {
        $projects = Projects::where('employer_id', (int) $user_id)
            ->count();

        return $projects;
    }

    public static function getProject($project_id, $filter = [])
    {
        $project = Projects::select(
            'projects.*',
            'users.id as user_id',
            'users.name as user_name',
            'users.profile_photo as user_profile_photo',
            'users.social as user_social',
            'user_categories_translations.name as user_category_name',
            'countries_translations.name as user_country_name',
            'countries.image as user_country_image',
            'users.address as user_address',
            'users.postalcode as user_postalcode',
            'users.created_at as user_created_at'
        )
            ->leftJoin('users', 'projects.employer_id', '=', 'users.id')
            ->leftJoin('user_categories_translations', function ($join) use ($filter) {
                $join->on('users.user_category', '=', 'user_categories_translations.user_category_id')
                    ->where('user_categories_translations.language_id', '=', $filter['language_id']);
            })
            ->leftJoin('countries', 'projects.country_id', '=', 'countries.id')
            ->leftJoin('countries_translations', function ($join) use ($filter) {
                $join->on('projects.country_id', '=', 'countries_translations.country_id')
                    ->where('countries_translations.language_id', '=', $filter['language_id']);
            })
            ->leftJoin('project_hireds', 'projects.id', '=', 'project_hireds.project_id')
            ->where('projects.id', $project_id);

        if (isset($filter['employer_id']) && $filter['employer_id'] > 0) {
            $project = $project->where('projects.employer_id', (int) $filter['employer_id']);
        }
        if (isset($filter['status'])) {
            $project = $project->where('projects.status', (int) $filter['status']);
        }
        if (isset($filter['freelancer_id']) && $filter['freelancer_id'] > 0) {
            if (isset($filter['project_hired']) && $filter['project_hired'] == true) {
                $project = $project->where('project_hireds.freelancer_id', (int) $filter['freelancer_id']);
            } else {
                $project = $project->where('projects.freelancer_id', (int) $filter['freelancer_id']);
            }
        }

        $project = $project->first();

        return $project;
    }

    public static function addProject($data = [])
    {
        $project = Projects::create(
            [
                'status' => (isset($data['status']) ? (int) $data['status'] : 0),
                'approve' => (isset($data['approve']) ? (int) $data['approve'] : 0),
                'employer_id' => (isset($data['user_id']) ? (int) $data['user_id'] : Auth::id()),
                'country_id' => (isset($data['country_id']) && $data['country_id'] > 0 ? (int) $data['country_id'] : null),
                'name' => (isset($data['name']) && !empty($data['name']) ? stripinput($data['name']) : null),
                'price_type' => (isset($data['price_type']) && $data['price_type'] > 0 ? (int) $data['price_type'] : null),
                'price' => (isset($data['price']) && $data['price'] > 0 ? (float) $data['price'] : null),
                'deadline' => (isset($data['deadline']) && !empty($data['deadline']) ? stripinput($data['deadline']) : null),
                'hired' => (isset($data['hired']) && !empty($data['hired']) ? stripinput($data['hired']) : null),
                'completed' => (isset($data['completed']) && !empty($data['completed']) ? stripinput($data['completed']) : null),
                'document' => (isset($data['document']) ? stripinput($data['document']) : null),
                'links' => (isset($data['links']) ? json_encode($data['links'], JSON_FORCE_OBJECT) : null),
                'description' => (isset($data['description']) && !empty($data['description']) ? $data['description'] : null),
            ]
        );

        if ($project && isset($data['user_category_id']) && !empty($data['user_category_id'])) {
            foreach ($data['user_category_id'] as $user_category_id):
                ProjectsCategories::add($project->id, $user_category_id);
            endforeach;

        }

        return $project;
    }

    public static function editProject($project_id, $data = [])
    {
        $user_id = Auth::id();

        $project = Projects::where('employer_id', $user_id)
            ->where('id', $project_id)
            ->where('status', 0)
            ->first();


        $project->employer_id = Auth::id();
        $project->country_id = (isset($data['country_id']) && $data['country_id'] > 0 ? (int) $data['country_id'] : null);
        $project->name = (isset($data['name']) && !empty($data['name']) ? stripinput($data['name']) : null);
        $project->price_type = (isset($data['price_type']) && $data['price_type'] > 0 ? (int) $data['price_type'] : null);
        $project->price = (isset($data['price']) && $data['price'] > 0 ? (float) $data['price'] : null);
        $project->deadline = (isset($data['deadline']) && !empty($data['deadline']) ? stripinput($data['deadline']) : null);
        $project->hired = (isset($data['hired']) && !empty($data['hired']) ? stripinput($data['hired']) : null);
        $project->completed = (isset($data['completed']) && !empty($data['completed']) ? stripinput($data['completed']) : null);
        $project->document = (isset($data['document']) ? stripinput($data['document']) : null);
        $project->links = (isset($data['links']) ? json_encode($data['links'], JSON_FORCE_OBJECT) : null);
        $project->description = (isset($data['description']) && !empty($data['description']) ? $data['description'] : null);
        $project->updated_at = Carbon::today();

        $project->save();

        ProjectsCategories::deleteByProjectId($project_id);
        if ($project && isset($data['user_category_id']) && !empty($data['user_category_id'])) {
            foreach ($data['user_category_id'] as $user_category_id):
                ProjectsCategories::add($project->id, $user_category_id);
            endforeach;
        }

        return $project;
    }

    public static function editProjectForAdmin($project_id, $data = [])
    {
        $user_id = $data['user_id'];



        $project = Projects::where('id', $project_id)
            ->first();



        $project->employer_id = (isset($data['user_id']) ? (int) $data['user_id'] : Auth::id());
        $project->status = (isset($data['status']) ? (int) $data['status'] : 0);
        $project->approve = (isset($data['approve']) ? (int) $data['approve'] : 0);
        $project->country_id = (isset($data['country_id']) && $data['country_id'] > 0 ? (int) $data['country_id'] : null);
        $project->name = (isset($data['name']) && !empty($data['name']) ? stripinput($data['name']) : null);
        $project->price_type = (isset($data['price_type']) && $data['price_type'] > 0 ? (int) $data['price_type'] : null);
        $project->price = (isset($data['price']) && $data['price'] > 0 ? (float) $data['price'] : null);
        $project->deadline = (isset($data['deadline']) && !empty($data['deadline']) ? stripinput($data['deadline']) : null);
        $project->hired = (isset($data['hired']) && !empty($data['hired']) ? stripinput($data['hired']) : null);
        $project->completed = (isset($data['completed']) && !empty($data['completed']) ? stripinput($data['completed']) : null);
        $project->document = (isset($data['document']) ? stripinput($data['document']) : null);
        $project->links = (isset($data['links']) ? json_encode($data['links'], JSON_FORCE_OBJECT) : null);
        $project->description = (isset($data['description']) && !empty($data['description']) ? $data['description'] : null);
        $project->updated_at = Carbon::today();

        $project->save();

        ProjectsCategories::deleteByProjectId($project_id);
        if ($project && isset($data['user_category_id']) && !empty($data['user_category_id'])) {
            foreach ($data['user_category_id'] as $user_category_id):
                ProjectsCategories::add($project->id, $user_category_id);
            endforeach;
        }

        return $project;
    }


    public static function editStatus($project_id, $status)
    {

        $project = Projects::where('id', $project_id)->first();
        $project->status = (int) $status;
        $project->save();


        return $project;
    }


    public function proposals()
    {
        return $this->hasMany(ProjectProposals::class, 'project_id', 'id');
    }
    //    public static function setFreelancer($project_id, $freelancer_id) {
//
//        $project = Projects::where('id', $project_id)->first();
//        $project->freelancer_id = (int)$freelancer_id;
//        $project->save();
//
//
//        return $project;
//    }

    public function projectsCategory()
    {
        return $this->belongsToMany(UserCategory::class, 'projects_categories', 'project_id', 'user_category_id');
    }

    public function scopeApprovedAndCategorized($query)
    {
        return $query->where(['status' => 1, 'approve' => 1])
        ->with('projectsCategory')
        ->whereHas('projectsCategory', function($q) {
            $q->distinct();
        });
    }

}

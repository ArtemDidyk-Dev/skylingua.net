<?php

namespace App\Http\Controllers\Admin\UserCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCategory\UserCategoryAddRequest;
use App\Http\Requests\UserCategory\UserCategoryEditRequest;
use App\Models\Language\Languages;
use App\Models\UserCategory\UserCategory;
use App\Models\UserCategory\UserCategoryTranslation;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserCategoryController extends Controller
{
    public $defaultLanguage;
    public $validatorCheck;


    public function __construct()
    {

        //Hansi dil defaultdursa onu caqir
        $this->defaultLanguage = cache('language-defaultID') == null ? Languages::where('default', 1)
            ->first()->id : cache('language-defaultID');

    }

    public function index(Request $request)
    {


        $user_categories = UserCategory::with(array('userCategoriesTranlations' => function ($query) {
            $query->where('language_id', $this->defaultLanguage);

        }))
            ->orderBy('id', 'DESC')
            ->paginate(10);


        return view('admin.user_category.index', compact('user_categories'));
    }

    public function add(Request $request)
    {


        return view('admin.user_category.add');
    }

    public function store(UserCategoryAddRequest $request)
    {

        $status = $request->status;
        $role_id = (int)$request->role_id;
        $image = $request->image;
        $slug = $request->slug;



        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        if (!in_array($status, [0, 1])) {
            $this->validateCheck('status', 'Səhv status.');
        }

        if (!in_array($role_id, [3, 4])) {
            $this->validateCheck('role_id', 'Error Role.');
        }

        $this->validatorCheck->validate();


        $user_category = UserCategory::create([
            'status' => $status,
            'role_id' => $role_id,
            'slug' => $slug == null ?? uniqueSlug('\App\Models\UserCategory\UserCategory', $slug),
            'image' => str_replace(env('APP_URL'), '', $image),
        ]);


        foreach ($request->name as $key => $name):

            UserCategoryTranslation::create([
                'name' => $name,
                'text' => $request->text[$key],
                'title' => $request->title[$key],
                'keyword' => $request->keyword[$key],
                'description' => $request->description[$key],
                'user_category_id' => $user_category->id,
                'language_id' => $key,
            ]);

        endforeach;

        return redirect()->route('admin.user_category.index');


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user_category = UserCategory::where('id', $id)
            ->with('userCategoriesTranlations')->first();

//        @dd( $user_category );


        return view('admin.user_category.edit', compact('user_category'));
    }

    public function update(UserCategoryEditRequest $request)
    {
        $id = $request->id;
        $status = $request->status;
        $role_id = (int)$request->role_id;
        $image = $request->image;
        $slug = $request->slug;

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        //Eger gonderilen ID sehfdirse
        $refererError = CommonService::refererError($id);
        if ($refererError) {
            $this->validateCheck('refererID', 'Səhf ID istifadə etdiniz!');
        }


        if (!in_array($status, [0, 1])) {
            $this->validateCheck('status', 'Səhv status.');
        }

        if (!in_array($role_id, [3, 4])) {
            $this->validateCheck('role_id', 'Error Role.');
        }

        $this->validatorCheck->validate();


        $user_category = UserCategory::where('id', $id)->first();
        if($user_category->slug != $slug){
            $user_category->slug = $slug ?? uniqueSlug('\App\Models\UserCategory\UserCategory', $request->name[cache('language-defaultID')]);
        }   
        $user_category->status = $status;
        $user_category->role_id = $role_id;
        $user_category->image = str_replace(env('APP_URL'), '', $image);
        $user_category->updated_at = date('Y-m-d H:i:s');
        $user_category->save();


        foreach ($request->name as $key => $name):
            UserCategoryTranslation::where('user_category_id', $id)
                ->where('language_id', $key)
                ->update([
                    'name' => $name,
                    'text' => $request->text[$key],
                    'title' => $request->title[$key],
                    'keyword' => $request->keyword[$key],
                    'description' => $request->description[$key],
                    'language_id' => $key,
                ]);



            //Eger yeni dil elave olunubsa bura ishleyecek.
            //Cunki databasede hemen tablede bele bir dil yoxdur update etmediyi ucun create etmelidir
            $userCategoryTranslation = UserCategoryTranslation::where('user_category_id', $id)
                ->where('language_id', $key)->first();

            if(!$userCategoryTranslation){
                UserCategoryTranslation::create([
                    'name' => $name,
                    'text' => $request->text[$key],
                    'title' => $request->title[$key],
                    'keyword' => $request->keyword[$key],
                    'description' => $request->description[$key],
                    'user_category_id' => $id,
                    'language_id' => $key,
                ]);
            }

        endforeach;

        return redirect()->route('admin.user_category.index');


    }

    public function search(Request $request)
    {
        $search = $request->search;

        $user_categories = UserCategory::where('language_id', $this->defaultLanguage)
            ->where('name', 'like', '%' . $search . '%')
            ->join('user_categories_translations','user_categories.id','=','user_categories_translations.user_category_id')
            ->orderBy('id', 'DESC')
            ->select(
                '*',
                'user_categories.updated_at as updated_at',
            )
            ->paginate(10);





        return view('admin.user_category.search', compact('user_categories'));
    }


    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $user_category = UserCategory::where('id', $id)->first();
        $data = '';
        $success = '';

        if ($user_category) {
            $user_category->status = $statusActive;
            $user_category->save();

            if ($statusActive == 1) {
                $data = 1;
            } else {
                $data = 0;
            }

            $success = true;
        } else {
            $success = false;

        }


        return response()->json(['success' => $success, 'data' => $data]);
    }

    public function sortAjax(Request $request)
    {
        foreach ($request->positions as $item):
            $id = $item[0];
            $sort = $item[1];
            $language = UserCategory::where('id', $id)->first();
            if ($language) {
                $language->sort = $sort;
                $language->save();
            }

        endforeach;


        return response()->json(['success' => true]);
    }

    public function deleteAjax(Request $request)
    {
        $id = $request->id;
        UserCategory::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }

    public function delete(Request $request)
    {

        $id = intval($request->id);

        UserCategory::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }

    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }
}

<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogAddRequest;
use App\Http\Requests\Blog\BlogEditRequest;
use App\Models\Language\Languages;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogTranslation;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
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


        $blogs = Blog::with(array('blogsTranlations' => function ($query) {
            $query->where('language_id', $this->defaultLanguage);

        }))
            ->orderBy('id', 'DESC')
            ->paginate(10);


        return view('admin.blog.index', compact('blogs'));
    }

    public function add(Request $request)
    {


        return view('admin.blog.add');
    }

    public function store(BlogAddRequest $request)
    {

        $status = $request->status;
        $image = $request->image;
        $slug = $request->slug;



        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        if (!in_array($status, [0, 1])) {
            $this->validateCheck('status', 'Səhv status.');
        }

        $this->validatorCheck->validate();


        $blog = Blog::create([
            'status' => $status,
            'slug' => $slug ?? uniqueSlug('\App\Models\Blog\Blog', $request->name[cache('language-defaultID')]),
            'image' => str_replace(env('APP_URL'), '', $image),
        ]);


        foreach ($request->name as $key => $name):

            BlogTranslation::create([
                'name' => $name,
                'text' => $request->text[$key],
                'title' => $request->title[$key],
                'keyword' => $request->keyword[$key],
                'description' => $request->description[$key],
                'blog_id' => $blog->id,
                'language_id' => $key,
            ]);

        endforeach;

        return redirect()->route('admin.blog.index');


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $blog = Blog::where('id', $id)
            ->with('blogsTranlations')->first();


        return view('admin.blog.edit', compact('blog'));
    }

    public function update(BlogEditRequest $request)
    {

        $id = $request->id;
        $status = $request->status;
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

        $this->validatorCheck->validate();


        $blog = Blog::where('id', $id)->first();
        if($blog->slug != $slug){
            $blog->slug = $slug ?? uniqueSlug('\App\Models\Blog\Blog', $request->name[cache('language-defaultID')]);
        }
        $blog->status = $status;
        $blog->image = str_replace(env('APP_URL'), '', $image);
        $blog->updated_at = date('Y-m-d H:i:s');
        $blog->save();


        foreach ($request->name as $key => $name):
            BlogTranslation::where('blog_id', $id)
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
            $blogTranslation = BlogTranslation::where('blog_id', $id)
                ->where('language_id', $key)->first();

            if(!$blogTranslation){
                BlogTranslation::create([
                    'name' => $name,
                    'text' => $request->text[$key],
                    'title' => $request->title[$key],
                    'keyword' => $request->keyword[$key],
                    'description' => $request->description[$key],
                    'blog_id' => $id,
                    'language_id' => $key,
                ]);
            }

        endforeach;

        return redirect()->route('admin.blog.index');


    }

    public function search(Request $request)
    {
        $search = $request->search;

        $blogs = Blog::where('language_id', $this->defaultLanguage)
            ->where('name', 'like', '%' . $search . '%')
            ->join('blogs_translations','blogs.id','=','blogs_translations.blog_id')
            ->orderBy('id', 'DESC')
            ->select(
                '*',
                'blogs.updated_at as updated_at',
            )
            ->paginate(10);





        return view('admin.blog.search', compact('blogs'));
    }


    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $blog = Blog::where('id', $id)->first();
        $data = '';
        $success = '';

        if ($blog) {
            $blog->status = $statusActive;
            $blog->save();

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
            $language = Blog::where('id', $id)->first();
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
        Blog::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }

    public function delete(Request $request)
    {

        $id = intval($request->id);

        Blog::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }

    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }
}

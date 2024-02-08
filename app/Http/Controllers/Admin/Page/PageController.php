<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\PageAddRequest;
use App\Http\Requests\Page\PageEditRequest;
use App\Models\Language\Languages;
use App\Models\Page\Page;
use App\Models\Page\PageTranslation;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller
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


        $pages = Page::with(array('pagesTranlations' => function ($query) {
            $query->where('language_id', $this->defaultLanguage);

        }))
            ->orderBy('id', 'DESC')
            ->paginate(10);


        return view('admin.page.index', compact('pages'));
    }

    public function add(Request $request)
    {


        return view('admin.page.add');
    }

    public function store(PageAddRequest $request)
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


        $page = Page::create([
            'status' => $status,
            'slug' => $slug ?? uniqueSlug('\App\Models\Page\Page', $request->name[cache('language-defaultID')]),
            'image' => str_replace(env('APP_URL'), '', $image),
        ]);


        foreach ($request->name as $key => $name):

            PageTranslation::create([
                'name' => $name,
                'text' => $request->text[$key],
                'title' => $request->title[$key],
                'keyword' => $request->keyword[$key],
                'description' => $request->description[$key],
                'page_id' => $page->id,
                'language_id' => $key,
            ]);

        endforeach;

        return redirect()->route('admin.page.index');


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $page = Page::where('id', $id)
            ->with('pagesTranlations')->first();


        return view('admin.page.edit', compact('page'));
    }

    public function update(PageEditRequest $request)
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


        $page = Page::where('id', $id)->first();
        if($page->slug != $slug){
            $page->slug = $slug ?? uniqueSlug('\App\Models\Page\Page', $request->name[cache('language-defaultID')]);
        }
        $page->status = $status;
        $page->image = str_replace(env('APP_URL'), '', $image);
        $page->updated_at = date('Y-m-d H:i:s');
        $page->save();


        foreach ($request->name as $key => $name):
            PageTranslation::where('page_id', $id)
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
            $pageTranslation = PageTranslation::where('page_id', $id)
                ->where('language_id', $key)->first();

            if(!$pageTranslation){
                PageTranslation::create([
                    'name' => $name,
                    'text' => $request->text[$key],
                    'title' => $request->title[$key],
                    'keyword' => $request->keyword[$key],
                    'description' => $request->description[$key],
                    'page_id' => $id,
                    'language_id' => $key,
                ]);
            }

        endforeach;

        return redirect()->route('admin.page.index');


    }

    public function search(Request $request)
    {
        $search = $request->search;

        $pages = Page::where('language_id', $this->defaultLanguage)
            ->where('name', 'like', '%' . $search . '%')
            ->join('pages_translations','pages.id','=','pages_translations.page_id')
            ->orderBy('id', 'DESC')
            ->select(
                '*',
                'pages.updated_at as updated_at',
            )
            ->paginate(10);





        return view('admin.page.search', compact('pages'));
    }


    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $page = Page::where('id', $id)->first();
        $data = '';
        $success = '';

        if ($page) {
            $page->status = $statusActive;
            $page->save();

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

    public function deleteAjax(Request $request)
    {
        $id = $request->id;
        Page::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }

    public function delete(Request $request)
    {

        $id = intval($request->id);

        Page::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }

    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }
}

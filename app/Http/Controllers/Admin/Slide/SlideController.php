<?php

namespace App\Http\Controllers\Admin\Slide;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slide\SlideAddRequest;
use App\Http\Requests\Slide\SlideEditRequest;
use App\Models\Language\Languages;
use App\Models\Slide\Slide;
use App\Models\Slide\SlideTranslation;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SlideController extends Controller
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


        $slides = Slide::with(array('slidesTranlations' => function ($query) {
            $query->where('language_id', $this->defaultLanguage);

        }))
            ->orderBy('sort', 'ASC')
            ->paginate(15);


        return view('admin.slide.index', compact('slides'));
    }

    public function add(Request $request)
    {
        return view('admin.slide.add');
    }

    public function store(SlideAddRequest $request)
    {


        $status = $request->status;
        $position = $request->position;

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        if (!in_array($status, [0, 1])) {
            $this->validateCheck('status', 'Səhv status.');
        }

        $this->validatorCheck->validate();

        $slide = Slide::create([
            'status' => $status,
            'position' => $position
        ]);

        foreach ($request->title as $key => $title):
            $slideTranslation = SlideTranslation::create([
                'title' => $title,
                'sub_title' => $request->sub_title[$key],
                'button_name' => $request->button_name[$key],
                'button_url' => $request->button_url[$key],
                'image' => str_replace(env('APP_URL'), '', $request->image[$key]),
                'slide_id' => $slide->id,
                'language_id' => $key,
            ]);

        endforeach;

        return redirect()->route('admin.slide.index');


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $slide = Slide::where('id', $id)
            ->with('slidesTranlations')->first();


        return view('admin.slide.edit', compact('slide'));
    }

    public function update(SlideEditRequest $request)
    {
        $id = $request->id;
        $status = $request->status;
        $position = $request->position;

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


        $slide = Slide::where('id', $id)
            ->update([
                'status' => $status,
                'position' => $position
            ]);

        foreach ($request->title as $key => $title):

            SlideTranslation::where('slide_id', $id)
                ->where('language_id', $key)
                ->update([
                    'title' => $title,
                    'sub_title' => $request->sub_title[$key],
                    'button_name' => $request->button_name[$key],
                    'button_url' => $request->button_url[$key],
                    'image' => str_replace(env('APP_URL'), '', $request->image[$key]),
                    'language_id' => $key,
                ]);

            //Eger yeni dil elave olunubsa bura ishleyecek.
            //Cunki databasede hemen tablede bele bir dil yoxdur update etmediyi ucun create etmelidir
            $slideTranslation = SlideTranslation::where('slide_id', $id)
                ->where('language_id', $key)->first();

            if(!$slideTranslation){
                SlideTranslation::create([
                    'title' => $title,
                    'sub_title' => $request->sub_title[$key],
                    'image' => str_replace(env('APP_URL'), '', $request->image[$key]),
                    'slide_id' => $id,
                    'language_id' => $key,
                ]);
            }

        endforeach;

        return redirect()->route('admin.slide.index');


    }


    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $slide = Slide::where('id', $id)->first();
        $data = '';
        $success = '';

        if ($slide) {
            $slide->status = $statusActive;
            $slide->save();

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
            $language = Slide::where('id', $id)->first();
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
        Slide::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }


    public function delete(Request $request)
    {

        $id = intval($request->id);

        Slide::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }


    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }

}

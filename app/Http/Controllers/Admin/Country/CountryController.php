<?php

namespace App\Http\Controllers\Admin\Country;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CountryAddRequest;
use App\Http\Requests\Country\CountryEditRequest;
use App\Models\Language\Languages;
use App\Models\Country\Country;
use App\Models\Country\CountryTranslation;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CountryController extends Controller
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


        $countries = Country::with(array('CountriesTranlations' => function ($query) {
            $query->where('language_id', $this->defaultLanguage);

        }))
            ->orderBy('id', 'DESC')
            ->paginate(10);



//        $countries = Country::with(array('CountriesTranlations' => function ($query) {
//            $query->where('language_id', $this->defaultLanguage);
//
//        }))
//            ->orderBy('id', 'DESC')
//            ->get();
//
//        if ($countries) {
//            foreach ($countries as $country) {
//                $country->image = "/storage/filemanager/images/countries/". strtolower($country->iso) .".png";
//
//                $country->save();
//            }
//        }
//
//        @dd($countries);


        return view('admin.country.index', compact('countries'));
    }

    public function add(Request $request)
    {


        return view('admin.country.add');
    }

    public function store(CountryAddRequest $request)
    {

        $iso = $request->iso;
        $status = $request->status;
        $image = $request->image;
        $slug = $request->slug;



        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        if (!in_array($status, [0, 1])) {
            $this->validateCheck('status', 'Səhv status.');
        }


        $this->validatorCheck->validate();


        $country = Country::create([
            'iso' => $iso,
            'status' => $status,
            'slug' => $slug ?? uniqueSlug('\App\Models\Country\Country', $request->name[cache('language-defaultID')]),
            'image' => str_replace(env('APP_URL'), '', $image),
        ]);


        foreach ($request->name as $key => $name):

            CountryTranslation::create([
                'name' => $name,
                'text' => $request->text[$key],
                'title' => $request->title[$key],
                'keyword' => $request->keyword[$key],
                'description' => $request->description[$key],
                'country_id' => $country->id,
                'language_id' => $key,
            ]);

        endforeach;

        return redirect()->route('admin.country.index');


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $country = Country::where('id', $id)
            ->with('CountriesTranlations')->first();



        return view('admin.country.edit', compact('country'));
    }

    public function update(CountryEditRequest $request)
    {
        $id = $request->id;
        $iso = $request->iso;
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


        $country = Country::where('id', $id)->first();
        if($country->slug != $slug){
            $country->slug = $slug ?? uniqueSlug('\App\Models\Country\Country', $request->name[cache('language-defaultID')]);
        }
        $country->iso = $iso;
        $country->status = $status;
        $country->image = str_replace(env('APP_URL'), '', $image);
        $country->updated_at = date('Y-m-d H:i:s');
        $country->save();


        foreach ($request->name as $key => $name):
            CountryTranslation::where('country_id', $id)
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
            $CountryTranslation = CountryTranslation::where('country_id', $id)
                ->where('language_id', $key)->first();

            if(!$CountryTranslation){
                CountryTranslation::create([
                    'name' => $name,
                    'text' => $request->text[$key],
                    'title' => $request->title[$key],
                    'keyword' => $request->keyword[$key],
                    'description' => $request->description[$key],
                    'country_id' => $id,
                    'language_id' => $key,
                ]);
            }

        endforeach;

        return redirect()->route('admin.country.index');


    }

    public function search(Request $request)
    {
        $search = $request->search;

        $countries = Country::where('language_id', $this->defaultLanguage)
            ->where('name', 'like', '%' . $search . '%')
            ->join('countries_translations','countries.id','=','countries_translations.country_id')
            ->orderBy('id', 'DESC')
            ->select(
                '*',
                'countries.updated_at as updated_at',
            )
            ->paginate(10);





        return view('admin.country.search', compact('countries'));
    }


    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $country = Country::where('id', $id)->first();
        $data = '';
        $success = '';

        if ($country) {
            $country->status = $statusActive;
            $country->save();

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
            $language = Country::where('id', $id)->first();
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
        Country::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }

    public function delete(Request $request)
    {

        $id = intval($request->id);

        Country::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }

    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }
}

<?php

namespace App\Http\Controllers\Admin\Language;

use App\Http\Controllers\Controller;
use App\Models\Language\LanguagePhraseTranslations;
use App\Models\Language\Languages;
use App\Services\Alert;
use App\Services\LanguageCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


class LanguageController extends Controller
{

    public function index(Request $request)
    {
        $languages = Languages::orderBy('sort')
            ->paginate(10);


        $countries = countries();
        $countryNames = [];
        $countryNativeNames = [];
        $countryCodes = [];
        $countriesAll = [];

        foreach ($countries as $country):
            $countryCodeCheck = strtolower($country['iso_3166_1_alpha2']);
            if ($countryCodeCheck != 'am') {
                $countryNames = $country['name'];
                $countryNativeNames = countryNameChange($country['native_name']);
                $countryCodes = strtolower($country['iso_3166_1_alpha2']);


                $countriesAll[] = [
                    'name' => $countryNames,
                    'nativeName' => $countryNativeNames,
                    'code' => countryCode($countryCodes)
                ];

            }
        endforeach;


        return view('admin.language.index', compact('languages', 'countriesAll'));
    }

    public function defaultStatus(Request $request)
    {
        $id = $request->id;

        $languages = Languages::all();
        $languageName = '';
        foreach ($languages as $language):
            if ($language->id == $id) {
                $language->default = 1;
                $language->status = 1;
                $languageName = $language->name;
            } else {
                $language->default = 0;
            }
            $language->save();
        endforeach;

        //eger keshde varsa sil
        if(Cache::has('language-default')){
            Cache::forget('language-default');
        }

        //eger keshde varsa sil
        if(Cache::has('language-defaultID')){
            Cache::forget('language-defaultID');
        }


        //BU dilleri keshden sildim frontda yeniden keshe yazsin deye
        Cache::forget('key-all-languages');

        //Aktiv dilleri aldim
        Cache::rememberForever('key-all-languages', function () {
            return Languages::where('status', 1)
                ->orderBy('sort','ASC')
                ->get();

        });


        Alert::success('', $languageName . ' dili default olaraq seçildi');
        return redirect()->route('admin.language.index');

    }

    public function sortAjax(Request $request)
    {
        foreach ($request->positions as $item):
            $id = $item[0];
            $sort = $item[1];
            $language = Languages::where('id', $id)->first();
            if ($language) {
                $language->sort = $sort;
                $language->save();
            }

        endforeach;


        //BU dilleri keshden sildim frontda yeniden keshe yazsin deye
        Cache::forget('key-all-languages');

        //Aktiv dilleri aldim
        Cache::rememberForever('key-all-languages', function () {
            return Languages::where('status', 1)
                ->orderBy('sort','ASC')
                ->get();

        });


        return response()->json(['success' => true]);
    }

    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $language = Languages::where('id', $id)->first();
        $data = '';
        $success = '';

        if ($language) {
            $language->status = $statusActive;
            $language->save();

            if ($statusActive == 1) {
                $data = 1;
            } else {
                $data = 0;
            }

            $success = true;
        } else {
            $success = false;

        }

        //BU dilleri keshden sildim frontda yeniden keshe yazsin deye
        Cache::forget('key-all-languages');

        //Aktiv dilleri aldim
        Cache::rememberForever('key-all-languages', function () {
            return Languages::where('status', 1)
                ->orderBy('sort','ASC')
                ->get();

        });


        return response()->json(['success' => $success, 'data' => $data]);
    }

    public function search(Request $request)
    {

        $languages = Languages::where('name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('code', 'LIKE', '%' . $request->search . '%')
            ->orWhere('short_name', 'LIKE', '%' . $request->search . '%')
            ->orderBy('sort')
            ->paginate(10);

        $searchText = $request->search;


        $countries = countries();
        $countryNames = [];
        $countryNativeNames = [];
        $countryCodes = [];
        $countriesAll = [];

        foreach ($countries as $country):


            $countryCodeCheck = strtolower($country['iso_3166_1_alpha2']);
            if ($countryCodeCheck != 'am') {
                $countryNames = $country['name'];
                $countryNativeNames = countryNameChange($country['native_name']);
                $countryCodes = strtolower($country['iso_3166_1_alpha2']);

                $countriesAll[] = [
                    'name' => $countryNames,
                    'nativeName' => $countryNativeNames,
                    'code' => countryCode($countryCodes)
                ];

            }
        endforeach;


        return view('admin.language.index', compact('languages', 'countriesAll', 'searchText'));


    }

    public function add(Request $request)
    {


        $rules = [
            'name' => 'sometimes|required|unique:languages,code',
            'short_name' => 'required|min:2',
            'sort' => 'nullable|integer'
        ];

        $messages = [
            'name.required' => 'Ad Mütləqdir',
            'name.unique' => 'Bu dil artıq bazada mövcuddur',
            'short_name.required' => 'Qısa ad mütləqdir',
            'short_name.min' => 'Qısa ad minimum 2 simvol olmalıdır',
            'sort.integer' => 'Səhv format.Sıralama yalnız rəqəmlərdən olmalıdır.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all()]);
        }

        $name = $request->name;
        //BU kod bazada olub olmadiqini yoxlamqcun service yazdim
        $languageCode = LanguageCode::code($name);

        //Eger varsa bu cod
        if (!$languageCode) {
            return response()->json(['error' => true, 'countyExists' => $name . ' adlı ölkə kodu bazada yoxdur']);
        } else {

            $country = country(countryCode($request->name,true));
            $name = countryNameChange($country->getNativeName());
            $shortName = $request->short_name;
            $code = $request->name;
            $sort = empty($request->sort) ? 0 : $request->sort;
            $status = $request->status == 'on' ? 1 : 0;

            $language = Languages::create([
                'name' => $name,
                'short_name' => $shortName,
                'code' => $code,
                'sort' => $sort,
                'status' => $status
            ]);

            //default dil hansidirsa onun idsini almaqcun etdim
            $defaultLanguageId = Languages::where('default', 1)->first();

            $phraseLanguageList = LanguagePhraseTranslations::where('language_id', $defaultLanguageId->id)->get();

            foreach ($phraseLanguageList as $item):
                $replicate = $item->replicate();
                $replicate->language_id = $language->id;
                $replicate->value = '';
                $replicate->save();
            endforeach;


            //BU dilleri keshden sildim frontda yeniden keshe yazsin deye
            Cache::forget('key-all-languages');

            //Aktiv dilleri aldim
            Cache::rememberForever('key-all-languages', function () {
                return Languages::where('status', 1)
                    ->orderBy('sort','ASC')
                    ->get();

            });


            return response()->json(['success' => true]);
        }


    }

    public function editAjax(Request $request)
    {
        $language = Languages::where('id', intval($request->languageID))->first();

        $data = [
            'formShortName' => $language->short_name,
            'formSort' => $language->sort,
            'fromDefault' => $language->default,
            'formStatus' => $language->status,
            'formID' => $language->id,
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $formID = intval($request->formID);
        $status = $request->status == 'on' ? 1 : 0;
        $default = $request->default == 'on' ? 1 : 0;

        $rules = [
            'name' => 'sometimes|required|unique:languages,code,' . $formID,
            'short_name' => 'required|min:2',
            'sort' => 'nullable|integer'
        ];

        $messages = [
            'name.required' => 'Ad Mütləqdir',
            'name.unique' => 'Bu dil artıq bazada mövcuddur',
            'short_name.required' => 'Qısa ad mütləqdir',
            'short_name.min' => 'Qısa ad minimum 2 simvol olmalıdır',
            'sort.integer' => 'Səhv format.Sıralama yalnız rəqəmlərdən olmalıdır.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all()]);
        }

        $name = $request->name;
        //BU kod bazada olub olmadiqini yoxlamqcun service ayzdim
        $languageCode = LanguageCode::code($name);

        $checkLanguageDefaultAndStatus = Languages::where('id', $formID)->first();

        //Eger varsa bu cod
        if (!$languageCode) {
            return response()->json(['error' => true, 'message' => $name . ' adlı ölkə kodu bazada yoxdur']);
        } elseif ($checkLanguageDefaultAndStatus->default == 1 && $default == 0) {
            return response()->json([
                'error' => true,
                'message' => $checkLanguageDefaultAndStatus->name  . ' adlı ölkə default
                 olaraq seçilidir.Saytda en azı bir dil default olaraq seçilməlidir!']);

        }elseif ($checkLanguageDefaultAndStatus->default == 1 && $status == 0) {
            return response()->json([
                'error' => true,
                'message' => $checkLanguageDefaultAndStatus->name  . ' adlı ölkə default
                 olaraq seçilidir.Dili deaktiv etmek mümkün olmadı!']);

        } else {

            $country = country(countryCode($request->name,true));
            $name = countryNameChange($country->getNativeName());
            $shortName = $request->short_name;
            $code = $request->name;
            $sort = empty($request->sort) ? 0 : $request->sort;


            $language = Languages::where('id', $formID)->update([
                'name' => $name,
                'short_name' => $shortName,
                'code' => $code,
                'sort' => $sort,
                'default' => $default,
                'status' => $status
            ]);


            if ($default === 1) {
                $languagesDefault = Languages::all();
                foreach ($languagesDefault as $language):
                    if ($language->id == $formID) {
                        $language->default = 1;
                        $language->status = 1;


                        //eger keshde varsa sil
                        if(Cache::has('language-default')){
                            Cache::forget('language-default');
                        }

                        //eger keshde varsa sil
                        if(Cache::has('language-defaultID')){
                            Cache::forget('language-defaultID');
                        }


                    } else {
                        $language->default = 0;
                    }
                    $language->save();
                endforeach;
            }


            //BU dilleri keshden sildim frontda yeniden keshe yazsin deye
            Cache::forget('key-all-languages');

            //Aktiv dilleri aldim
            Cache::rememberForever('key-all-languages', function () {
                return Languages::where('status', 1)
                    ->orderBy('sort','ASC')
                    ->get();

            });

            return response()->json(['success' => true]);
        }


    }

    public function deleteAjax(Request $request)
    {
        $languageID = $request->id;

        $language = Languages::where('id',$languageID)
            ->first();

        if($language->default == 1){
            return response()->json(['error' => true,'languageName' => $language->name],200);
        }

        return response()->json(['success' => true,'languageName' => $language->name],200);


    }

    public function delete(Request $request)
    {

        $languageID = intval($request->id);

        $language = Languages::where('id',$languageID)->delete();


        //BU dilleri keshden sildim frontda yeniden keshe yazsin deye
//        Cache::forget('key-all-languages');
        Artisan::call('optimize:clear');

        //Aktiv dilleri aldim
        Cache::rememberForever('key-all-languages', function () {
            return Languages::where('status', 1)
                ->orderBy('sort','ASC')
                ->get();

        });

        return response()->json(['success' => true],200);

    }

}

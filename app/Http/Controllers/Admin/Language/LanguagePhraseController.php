<?php

namespace App\Http\Controllers\Admin\Language;

use App\Http\Controllers\Controller;
use App\Models\Language\LanguageGroups;
use App\Models\Language\LanguagePhrases;
use App\Models\Language\LanguagePhraseTranslations;
use App\Models\Language\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LanguagePhraseController extends Controller
{

    public function index(Request $request)
    {


        $languages = Languages::all();

        $languageGroups = LanguageGroups::all();

        $languagePhrases = LanguagePhrases::with(['translate', 'languageGroups'])
            ->orderBy('id', 'DESC')
            ->paginate(10);


        return view('admin.language.phrase.index', compact('languagePhrases', 'languages', 'languageGroups'));


    }

    public function add(Request $request)
    {

        $groupID = $request->groupID;
        $key = $request->key;
        $translate = '';
        $editor = '';
        $editorActive = $request->editorActive == 'on' ? true : false;


        if ($editorActive) {
            $translate = $request->translateEditor;
            $editor = 1;
        } else {
            $translate = $request->translate;
            $editor = 0;
        }


        $rules = [
            'key' => 'sometimes|required|min:1|unique:language_phrases,key',
            'groupID' => 'required|integer|exists:language_groups,id',
        ];

        $messages = [
            'key.required' => 'Key mütləqdir',
            'key.unique' => 'Bu key artıq bazada mövcuddur',
            'key.min' => 'Key adı minimum 2 simvol olmalıdır',
            'groupID.required' => 'Qrup mütləqdir',
            'groupID.exists' => 'Bu qrup ID bazada yoxdur',
            'groupID.integer' => 'Qrup ID yalnız rəqəmlərdən olmalıdır',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all()]);
        } else {

            $languagePhrases = LanguagePhrases::create([
                'key' => $key,
                'language_group_id' => $groupID,
                'editor' => $editor
            ]);


            foreach ($translate as $key => $value):

                LanguagePhraseTranslations::create([
                    'value' => $value,
                    'language_id' => $key,
                    'phrase_id' => $languagePhrases->id
                ]);

            endforeach;


            return response()->json(['success' => true]);
        }

    }

    public function editAjax(Request $request)
    {

        $languagePhraseID = intval($request->languagePhraseID);

        $LanguagePhrases = LanguagePhrases::with('translate')->where('id', $languagePhraseID)->get();


        foreach ($LanguagePhrases as $item):
            //tercumeleri her dil ucun ayri gondermeye ucun relation istifade edirem
            $translateValue = [];
            foreach ($item->translate as $translate):
                $translateValue[$translate->language_id] = $translate->value;
            endforeach;

            $data = [
                'phraseID' => $item->id,
                'phraseKey' => $item->key,
                'translate' => $translateValue,
                'editor' => $item->editor
            ];

        endforeach;


        return response()->json(['success' => $data], 200);

    }

    public function update(Request $request)
    {
        $groupID = intval($request->groupID);
        $phraseID = intval($request->phraseID);
        $key = $request->key;
        $translate = '';
        $editor = '';
        $editorActive = $request->editorActive == 'on' ? true : false;


        if ($editorActive) {
            $translate = $request->translateEditor;
            $editor = 1;
        } else {
            $translate = $request->translate;
            $editor = 0;
        }




        $rules = [
            'key' => 'sometimes|required|min:1|unique:language_phrases,key,'.$phraseID,
            'groupID' => 'required|integer|exists:language_groups,id',
            'phraseID' => 'required|integer|exists:language_phrases,id',
        ];

        $messages = [
            'key.required' => 'Key mütləqdir',
            'key.unique' => 'Bu key artıq bazada mövcuddur',
            'key.min' => 'Key adı minimum 2 simvol olmalıdır',
            'groupID.required' => 'Qrup mütləqdir',
            'groupID.exists' => 'Bu qrup ID bazada yoxdur',
            'groupID.integer' => 'Qrup ID yalnız rəqəmlərdən olmalıdır',
            'phraseID.required' => 'Ifade ID mütləqdir',
            'phraseID.exists' => 'Bu Ifade ID bazada yoxdur',
            'phraseID.integer' => 'Ifade ID yalnız rəqəmlərdən olmalıdır',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all()]);
        } else {

            $languagePhrases = LanguagePhrases::where('id',$phraseID)
                ->update([
                    'key' => $key,
                    'language_group_id' => $groupID,
                    'editor' => $editor
                ]);


            foreach ($translate as $key => $value):

                LanguagePhraseTranslations::where('phrase_id',$phraseID)
                    ->where('language_id',$key)
                    ->update([
                        'value' => $value,
                        'language_id' => $key,
                        'phrase_id' => $phraseID
                    ]);

            endforeach;



            $languagePhraseForget = Languages::all();
            //Keshden bu key li olan dil tercumesini sil
            foreach ($languagePhraseForget as $item):
                if(Cache::has($item->code.'.'.$request->key)){
                    Cache::forget($item->code.'.'.$request->key);
                }
            endforeach;


            return response()->json(['success' => true]);
        }

    }

    public function search(Request $request)
    {


        $languages = Languages::all();


        $languageGroups = LanguageGroups::all();


            $searchText = $request->search;


            $languagePhrases = LanguagePhrases::whereHas('translate', function ($query) use ($searchText){
                $query->where('value', 'like', '%'.$searchText.'%')
                    ->orWhere('key', 'like', '%'.$searchText.'%');
            })->with('languageGroups')
                ->orderBy('id', 'DESC')
                ->paginate(10);





            return view('admin.language.phrase.index', compact('languagePhrases', 'languages','languageGroups','searchText'));


    }


    public function deleteAjax(Request $request)
    {
        $languagePhraseID = intval($request->id);

        $LanguagePhrases = LanguagePhrases::where('id', $languagePhraseID)
            ->first();

        return response()->json(['success' => true, 'languagePhraseKey' => $LanguagePhrases->key], 200);
    }

    public function delete(Request $request)
    {

        $languagePhraseID = intval($request->id);

        $LanguagePhrases = LanguagePhrases::where('id', $languagePhraseID)->delete();

        if ($LanguagePhrases) {
            return response()->json(['success' => true], 200);
        }

    }

}

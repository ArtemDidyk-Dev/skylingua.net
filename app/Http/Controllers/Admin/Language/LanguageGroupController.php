<?php

namespace App\Http\Controllers\Admin\Language;

use App\Http\Controllers\Controller;
use App\Models\Language\LanguageGroups;
use App\Models\Language\LanguagePhrases;
use App\Models\Language\LanguagePhraseTranslations;
use App\Models\Language\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LanguageGroupController extends Controller
{

    public function index()
    {

        $languageGroups = LanguageGroups::with('countPhrase')
            ->orderBy('id', 'DESC')
            ->paginate(10);

       return view('admin.language.group.index', compact('languageGroups'));

    }

    public function groupSearch(Request $request)
    {

        $languageGroups = LanguageGroups::orderBy('id', 'DESC')
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('description', 'LIKE', '%' . $request->search . '%')
            ->paginate(10);

        $searchText = $request->search;


        return view('admin.language.group.index', compact('languageGroups', 'searchText'));


    }

    public function groupDetail(Request $request)
    {
        $id = $request->id;

        $languages = Languages::all();

        $languageGroup = LanguageGroups::where('id', $id)->first();

        $languageGroups = LanguageGroups::all();

        if (!$languageGroup) {
            abort(404);
        } else {
            $languagePhrases = LanguagePhrases::with('translate')
                ->where('language_group_id', $id)
                ->orderBy('id', 'DESC')
                ->paginate(10);


            return view('admin.language.group.detail', compact('languagePhrases', 'languages', 'languageGroup','languageGroups'));
        }


    }

    public function groupAdd(Request $request)
    {
        $name = $request->name;
        $description = $request->description;
        $slug = Str::slug($request->name, '-');

        $rules = [
            'name' => 'sometimes|required|min:2|unique:language_groups,name',
        ];

        $messages = [
            'name.required' => 'Ad Mütləqdir',
            'name.unique' => 'Bu grup adı artıq bazada mövcuddur',
            'name.min' => 'Grup adı minimum 2 simvol olmalıdır',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all()]);
        } else {

            $languageGroups = LanguageGroups::create([
                'name' => $name,
                'description' => $description,
                'slug' => $slug
            ]);

            return response()->json(['success' => true]);
        }


    }

    public function groupEditAjax(Request $request)
    {
        $LanguageGroup = LanguageGroups::where('id', intval($request->languageGroupID))->first();

        $data = [
            'name' => $LanguageGroup->name,
            'description' => $LanguageGroup->description,
            'formID' => $LanguageGroup->id
        ];

        return response()->json($data, 200);
    }

    public function groupUpdate(Request $request)
    {
        $formID = intval($request->formID);

        $name = $request->name;
        $description = $request->description;
        $slug = Str::slug($request->name, '-');

        $rules = [
            'name' => 'sometimes|required|min:2|unique:language_groups,name,' . $formID,
        ];

        $messages = [
            'name.required' => 'Ad Mütləqdir',
            'name.unique' => 'Bu grup adı artıq bazada mövcuddur',
            'name.min' => 'Grup adı minimum 2 simvol olmalıdır',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->all()]);
        } else {

            $languageGroups = LanguageGroups::where('id', $formID)->update([
                'name' => $name,
                'description' => $description,
                'slug' => $slug
            ]);

            return response()->json(['success' => true]);
        }

    }

    public function deleteAjax(Request $request)
    {
        $languageGroupID = intval($request->id);

        $LanguageGroups = LanguageGroups::where('id', $languageGroupID)
            ->first();

        return response()->json(['success' => true, 'languageGroupName' => $LanguageGroups->name], 200);

    }

    public function groupDelete(Request $request)
    {

        $languageGroupID = intval($request->id);

        $LanguageGroups = LanguageGroups::where('id', $languageGroupID)->delete();

        if ($LanguageGroups) {
            return response()->json(['success' => true], 200);
        }

    }

    public function groupDetailPhraseAdd(Request $request)
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
            'groupID.required' => 'Qrup ID mütləqdir',
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


    public function groupDetailPhraseEditAjax(Request $request)
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


    public function groupDetailPhraseUpdate(Request $request)
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


    public function groupDetailSearch(Request $request)
    {
        $id = $request->id;

        $languages = Languages::all();

        $languageGroup = LanguageGroups::where('id', $id)->first();

        $languageGroups = LanguageGroups::all();

        if (!$languageGroup) {
            abort(404);
        } else {

            $searchText = $request->search;


            $languagePhrases = LanguagePhrases::whereHas('translate', function ($query) use ($searchText){
                   $query->where('value', 'like', '%'.$searchText.'%')
                       ->orWhere('key', 'like', '%'.$searchText.'%');
               })
                ->where('language_group_id', $id)
                ->orderBy('id', 'DESC')
                ->paginate(10);



            return view('admin.language.group.detail', compact('languagePhrases', 'languages', 'languageGroup','languageGroups','searchText'));
        }


    }

    public function groupDetailDeleteAjax(Request $request)
    {
        $languagePhraseID = intval($request->id);

        $LanguagePhrases = LanguagePhrases::where('id', $languagePhraseID)
            ->first();

        return response()->json(['success' => true, 'languagePhraseKey' => $LanguagePhrases->key], 200);

    }

    public function groupDetailDelete(Request $request)
    {

        $languagePhraseID = intval($request->id);

        $LanguagePhrases = LanguagePhrases::where('id', $languagePhraseID)->delete();

        if ($LanguagePhrases) {
            return response()->json(['success' => true], 200);
        }

    }



}

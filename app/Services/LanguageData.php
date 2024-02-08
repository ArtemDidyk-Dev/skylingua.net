<?php


namespace App\Services;


use App\Models\Language\LanguagePhrases;
use App\Models\Language\Languages;
use Illuminate\Support\Facades\Cache;

class LanguageData
{



    public static function getKeys(int $languageID, $languageCode = null)
    {
        $data = '';
//        $data = LanguagePhrases::join('language_groups', 'language_groups.id', '=', 'language_phrases.language_group_id')
//            ->join('language_phrase_translations', 'language_phrase_translations.phrase_id', '=', 'language_phrases.id')
////            ->whereIn('language_groups.slug', $languageGroups)
//            ->where('language_phrase_translations.language_id', $languageID)
//            ->select('value', 'key')
//            ->pluck('value', 'key')
//            ->toArray();


        return $data;
    }

    public static function getList()
    {
        $languages = Languages::orderBy('sort')->get();
        return $languages;
    }

    public static function getDefaultLanguage()
    {
        $languageDefault = Languages::where('default', 1)->first();

        $language = [];
        $language['name'] = $languageDefault['name'];
        $language['short_name'] = $languageDefault['short_name'];
        $language['code'] = $languageDefault['code'];


        return $language;
    }

    public static function getLanguageCode($languageID)
    {
        $language = Languages::where('id', $languageID)
            ->select('code')
            ->first();

        return $language->code;
    }




}

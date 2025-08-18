<?php


namespace App\Services;


use App\Models\Language\Languages;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{

    public static function getSetting($key,$languageID = null)
    {

        if(!is_null($languageID)){

            Cache::rememberForever('setting-'.$key.'-'.$languageID, function () use ($key,$languageID) {
                $setting =   Setting::where('settings.key',$key)
                    ->where('settings_translations.language_id',$languageID)
                    ->join('settings_translations','settings.id','=','settings_translations.setting_id')
                    ->first();

                if(!is_null($setting)){
                    return !empty($setting->content) ?$setting->content:'';
                }

            });

            //Eger keshde bu varsa
            if(Cache::has('setting-'.$key.'-'.$languageID)){
                return Cache::get('setting-'.$key.'-'.$languageID);
            }


        }else{

            Cache::rememberForever('setting-'.$key, function () use ($key) {
                $setting =  Setting::where('key',$key)
                    ->first();

                if($setting){
                    return !empty($setting->content) ?$setting->content:'';
                }
            });

            //Eger keshde bu varsa
            if(Cache::has('setting-'.$key)){
                return Cache::get('setting-'.$key);
            }



        }


    }




}

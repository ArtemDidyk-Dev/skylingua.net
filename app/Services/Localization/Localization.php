<?php
/*
 * Eger default dilinde URL de gorunmeyini isteyirsense if shertini sil
 * tekce bunu saxla
 *
 * return $locale;
 *
 */


namespace App\Services\Localization;


use Illuminate\Support\Facades\Cache;

class Localization
{
    public function locale() {
        $locale = request()->segment(1, '');

        if($locale && in_array($locale, config("localization.locale_all"))) {

            if(Cache::get('language-default') == $locale){
                return '';
            }else{
                //Eger default dilinde URL de gorunmeyini isteyirsense if shertini sil
                //tekce bunu saxla  return $locale;
                return $locale;
            }
        }

        return "";
    }
}

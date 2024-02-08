<?php

namespace App\Http\Middleware;

use App\Models\Language\Languages;
use App\Services\LanguageData;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        //Hal ahzikri dil
        $currentLang = App::getLocale();


        Cache::rememberForever('language-default', function () {
            $languageDefault = Languages::where('default', 1)
                ->first();
            return $languageDefault->code;
        });

        //Istenilen dil
        $reqLang = request()->segment(1, '');

        if ($reqLang && in_array($reqLang, config("localization.locale_all"))) {
            $reqLang = request()->segment(1, '');
        } else {

            //default dili cache yazdim
            $reqLang = Cache::get('language-default');
        }


        if ($reqLang != $currentLang) {
            //Dil kantrolu
            $langControl = Languages::where('code', $reqLang)
                ->where('status', 1)
                ->first();

            if ($langControl) {
                //Dil istifade oluna biler
                App::setLocale($reqLang);
                $currentLang = $reqLang;
                $languageID = $langControl->id;
                $languageCode = $langControl->code;

            } else {
                abort(404);
            }

        } else {
            $langControl = Languages::where('code', $currentLang)->first();
            $languageID = $langControl->id;
            $languageCode = $langControl->code;

        }


        //Aktiv dilleri aldim
        $allLanguages = Cache::rememberForever('key-all-languages', function () {
            return Languages::where('status', 1)
                ->get();

        });


        /*
         *     Dili cookie -ye yazdim  sehife tikladiqda hansi dildirse ora yoneldsin
         */
        if (!isset($_COOKIE['current_language'])) {
            setcookie('current_language', Cache::get('language-default'), time() + (86400 * 90), "/");
        }


        /*
         * Eger default dil beraber deyilse cookideki dile yonlendir default dile
         */

        $languageChechk = [];
        foreach (cache('key-all-languages') as $languageCode):
            $languageChechk[] = $languageCode->code;
        endforeach;

        if (isset($_COOKIE['current_language'])) {

            if (!in_array($_COOKIE['current_language'], $languageChechk)) {
                setcookie('current_language', Cache::get('language-default'), time() + (86400 * 90), "/");
            } else {

                if (($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '')) {
                    if (isset($_COOKIE['current_language']) && $_COOKIE['current_language'] != Cache::get('language-default')) {
                        return redirect()->to(trim(env('APP_URL'), '/') . '/' . $_COOKIE['current_language']);
                    }
                }

            }
        }




        $request->request->add(['allLanguages' => Cache::get('key-all-languages')]);
        $request->request->add(['languageID' => $languageID]);
        $request->request->add(['currentLang' => $currentLang]);

        view()->share('allLanguages', Cache::get('key-all-languages'));
        view()->share('languageID', $languageID);
        view()->share('currentLang', $currentLang);

        return $next($request);
    }
}

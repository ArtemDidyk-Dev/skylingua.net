<?php

namespace App\Http\Middleware;

use App\Models\Language\Languages;
use App\Services\LanguageData;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Hal ahzikri dil
        $currentLang = App::getLocale();

        //Istenilen dil
        $reqLang = $request->segment(1);


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

            } else {
                //istenilen dil yoxdursa ve ya aktiv deyilse
                return redirect()->route('home.index', ['locale' => $currentLang]);
            }

        } else {
            $langControl = Languages::where('code', $currentLang)->first();
            $languageID = $langControl->id;
        }


        $pageName = $request->segment(2);

        $fixedGroupNames = ['general', 'menu', 'footer', 'error-page'];

        switch ($pageName) {
            case 'anket':
                $fixedGroupNames[] = 'occupaiton';
                break;
            case 'contact':
                $fixedGroupNames[] = 'contact';
                break;
        }


        $language = LanguageData::getKeys($fixedGroupNames, $languageID);

//        @dd($language);

        $request->request->add(['language' => $language]);
        $request->request->add(['languageID' => $languageID]);
        $request->request->add(['currentLang' => $currentLang]);

        view()->share('language',$language);
        view()->share('languageID',$languageID);
        view()->share('currentLang',$currentLang);


        return $next($request);
    }
}

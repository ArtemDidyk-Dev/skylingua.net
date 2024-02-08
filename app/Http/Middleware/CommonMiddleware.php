<?php

namespace App\Http\Middleware;

use App\Models\Chats\ChatMessages;
use App\Models\Language\Languages;
use App\Models\Notification\Notification;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CommonMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        //Aktiv dilleri aldim
        Cache::rememberForever('key-all-languages', function () {
            return Languages::where('status', 1)
                ->orderBy('sort','ASC')
                ->get();

        });




        //Default Dili aldim
        Cache::rememberForever('language-defaultID', function () {
            $languageDefault = Languages::where('default', 1)
                ->first();
            return $languageDefault->id;
        });



        //Default Dili aldim
        Cache::rememberForever('language-default', function () {
            $languageDefault = Languages::where('default', 1)
                ->first();
            return $languageDefault->code;
        });




        //Notification && Message count
        if (Auth::check()) {
            $user_id = (int)Auth::id();
            $notification_count = Notification::where('user_id', $user_id)
                ->where('status', 0)
                ->count();

            $message_count = ChatMessages::where('user_to', $user_id)
                ->where('status', 0)
                ->count();

            view()->share('notification_count', $notification_count);
            view()->share('message_count', $message_count);
        }




        view()->share('HTTP_HOST', $request->getSchemeAndHttpHost());


        return $next($request);
    }
}

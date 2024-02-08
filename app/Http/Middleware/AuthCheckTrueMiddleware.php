<?php

namespace App\Http\Middleware;

use App\Models\Language\Languages;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthCheckTrueMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        if (Auth::check()) {
            return redirect()->route('frontend.dashboard.index');
        }


        return $next($request);
    }
}

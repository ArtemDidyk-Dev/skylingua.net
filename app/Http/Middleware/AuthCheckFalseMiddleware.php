<?php

namespace App\Http\Middleware;

use App\Models\Language\Languages;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthCheckFalseMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        if (!Auth::check()) {
            return redirect()->route('frontend.login.index');
        }


        return $next($request);
    }
}

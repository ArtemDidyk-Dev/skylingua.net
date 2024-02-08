<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomCKFinderAuth
{


    public function handle($request, Closure $next)
    {
        config(['ckfinder.authentication' => function() {
            return true;
        }]);
        return $next($request);
    }


}

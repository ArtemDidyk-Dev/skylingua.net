<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheControlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

//        $response->header('Cache-Control', 'no-cache, must-revalidate');
        // Or whatever you want it to be:
//         $response->header('Cache-Control', 'must-revalidate, public, max-age=3600');

        return $response;
    }
}

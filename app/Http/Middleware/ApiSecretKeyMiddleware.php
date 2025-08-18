<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiSecretKeyMiddleware
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

        $api_secret_id = trim($request->api_secret_id);
        $api_secret_key = trim($request->api_secret_key);


        if ($api_secret_id != env('TOKEN_SECRET_ID') || $api_secret_key != env('TOKEN_SECRET_KEY')) {
            return  response()->json([
                'message' => 'Secret id or Secret key invalid',
                'error' => true,
                'isToken' => false,
            ],401);
        }


        return $next($request);

    }
}

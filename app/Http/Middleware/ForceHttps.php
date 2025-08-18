<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        if (!$request->secure() && env('APP_ENV') === 'prod') {
            return redirect()->secure($request->getRequestUri());
        }
        if (strpos($host, 'www.') === 0 && env('APP_ENV') === 'prod') {
            $newHost = substr($host, 4);
            return redirect()->to($request->path(), 301, [], $secure = null)->setTargetUrl('https://' . $newHost . $request->getPathInfo());
        }
        return $next($request);
    }
}

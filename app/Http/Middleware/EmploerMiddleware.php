<?php

namespace App\Http\Middleware;

use App\Services\CommonService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploerMiddleware
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

        $user = CommonService::userRoleId(Auth::id());

        if($user == 4){
            return redirect()->route('frontend.dashboard.freelancer');
        }



        return $next($request);
    }
}

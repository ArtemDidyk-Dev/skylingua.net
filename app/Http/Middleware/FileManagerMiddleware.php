<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileManagerMiddleware
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

        $user = User::with('roles')
            ->where('id',Auth::id())
            ->first();

        //Istfiadecidirse yonlendir
        $checkAdmin =  $user->roles[0]->id;
        if($checkAdmin == 3){
              return redirect()->route('admin.permission');
        }


        return $next($request);
    }
}

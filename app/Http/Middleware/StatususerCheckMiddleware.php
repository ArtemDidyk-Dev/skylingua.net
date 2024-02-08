<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatususerCheckMiddleware
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

        //useri rollari ile birge al
        $user = User::with('roles')
            ->where('id',Auth::id())
            ->first();

        //Statusu 0 dirsa yonlendir
        if ($user->status == 0) {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors(['Sizin buna icazəniz yoxdur']);

            //Eger Itsifadechidirse yonlendir
        } else if($user->roles[0]->id > 2) {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors(['Sizin buna icazəniz yoxdur']);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function index(Request $request)
    {

        return view('frontend.cabinet.login');

    } // public function login


    public function store(LoginRequest $request)
    {

        $email = $request->email;
        $password = $request->password;
        $remember = $request->has('remember') ? true : false;


        //eger istfiadeci statusu aktivdirse daxil et deyilse logout edecey ashaqida
        $user = User::where(function ($query) use ($email) {

            $query->where('email', $email)->where('status', 1);

        })->first();



        if($user && Hash::check($password, $user->password)){

            Auth::login($user,$remember);

            return redirect()->route('frontend.dashboard.index');

        }else{
            //eger istfiadeci statusu passivdirse logout et
            return redirect()->route('frontend.login.index')->withErrors([
                'error' => language('frontend.login.error_incorrect')
            ]);
        }


    } // public function login

    public function logout()
    {
        Auth::logout();
        return redirect()->route('frontend.login.index');
    }


}

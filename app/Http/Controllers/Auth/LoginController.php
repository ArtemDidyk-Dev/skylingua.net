<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('admin.index');
        }

        return view('admin.auth.index');
    }

    public function login(LoginRequest $request)
    {

        $email = $request->email;
        $password = $request->password;
        $remember = $request->has('remember') ? true : false;


        //eger istfiadeci statusu aktivdirse daxil et deyilse logout edecey ashaqida
        $user = User::where(function ($query) use ($email) {

            $query->where('email', $email)->where('status', 1);

//        })->orWhere(function ($query) use ($email) {
//
//            $query->where('username', $email)->where('status', 1);

        })->first();



        if($user && Hash::check($password,$user->password)){

            Auth::login($user,$remember);
            return redirect()->route('admin.index');

        }else{
            //eger istfiadeci statusu passivdirse logout et
            return redirect()->route('admin.login')->withErrors(['İstifadəçi adı və ya şifrə yalnışdır.']);
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');

    }


}

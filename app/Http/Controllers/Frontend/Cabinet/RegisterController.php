<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use App\Mail\Frontend\RegisterMail;
use App\Models\Chats\ChatMessages;
use App\Models\Chats\Chats;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function register(Request $request)
    {


        $user['roles'] = ($request->role ? (int)$request->role : 4);
        $user['name'] = "";
        $user['email'] = "";
        $user['password'] = "";
        $user['password_confirmation'] = "";
        $user['agree'] = 0;


        $user = (object) $user;


        return view('frontend.cabinet.register', compact('user'));

    } // public function register

    public function store(UserRegisterRequest $request)
    {

        $verify = Str::random(100);

        $user['roles'] = ($request->roles == 4 ? 4 : 3);
        $user['name'] = stripinput($request->name);
        $user['email'] = stripinput($request->email);
        $user['password'] = $request->password;
        $user['password_confirmation'] = $request->password_confirmation;
        $user['agree'] = ($request->agree == 1 ? 1 : 0);
        $user['verify'] = $verify;


        $new_user = User::add($user);

        if ($new_user->id > 0) {

            $toMail = $user['email'];

            $mail_data = [
                'verify' => $verify,
            ];

            Mail::to($toMail)
                ->send(new RegisterMail($mail_data));

            return redirect()->route('frontend.cabinet.success');
        } else {
            return redirect()->route('frontend.cabinet.register');
        }

    } // public function store

    public function verify(Request $request) {

        $data = [];

        $verify = stripinput($request->verify);
        if (!empty($verify)) {
            $user = User::getByVerify($verify);
        } else {
            $user = null;
        }
        if ($user) {

            $user->verify = "";
            $user->status = 1;
            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->save();


            // TODO:: Add Admin Message
            $user_from = 1;
            $user_to = (int)$user->id;
            $message = language('Welcome to our platform, if you have any questions write to us.');
            $file = "";

            $chat = Chats::getChat($user_from, $user_to);
            if (!$chat) {
                Chats::createChat($user_from, $user_to);
            }
            ChatMessages::addMessages($user_from, $user_to, $message, $file);


            $request->session()->put('chat_user_to', $user_to);

            $data['status'] = true;
            $data['message'] = language('frontend.register.verified');

        } else {


            $data['status'] = false;
            $data['message'] = language('frontend.register.not_verified');

        } //

        return view('frontend.cabinet.verify', compact('data'));

    } // public function verify




    public function success(Request $request)
    {

        $data['status'] = true;
        $data['title'] = language('frontend.register.title');
        $data['name'] = language('frontend.register.name');
        $data['keywords'] = language('frontend.register.keywords');
        $data['description'] = language('frontend.register.description');
        $data['message'] = language('frontend.register.success');

        return view('frontend.cabinet.success', compact('data'));

    } // public function success


}

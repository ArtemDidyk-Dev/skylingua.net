<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\PasswordResetsRequest;
use App\Mail\Frontend\ForgotMail;
use App\Mail\Frontend\PasswordResetsMail;
use App\Models\PasswordResets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotController extends Controller
{

    public function index(Request $request)
    {

        $user['email'] = "";

        $user = (object) $user;

        return view('frontend.cabinet.forgot', compact('user'));

    } // public function forgot



    public function store(ForgotPasswordRequest $request)
    {

        $token = Str::random(100);

        $email = stripinput($request->email);


            $data['email'] = $email;
            $data['token'] = $token;

            $new_user = PasswordResets::add($data);


            $toMail = $email;

            $mail_data = [
                'token' => $token,
            ];

            Mail::to($toMail)
                ->send(new ForgotMail($mail_data));

            return redirect()->route('frontend.forgot.success');


    } // public function store



    public function success(Request $request)
    {

        $data['status'] = true;
        $data['title'] = language('frontend.forgot.title');
        $data['name'] = language('frontend.forgot.name');
        $data['keywords'] = language('frontend.forgot.keywords');
        $data['description'] = language('frontend.forgot.description');
        $data['message'] = language('frontend.forgot.success');

        return view('frontend.cabinet.success', compact('data'));

    } // public function success



    public function error(Request $request)
    {

        $data['status'] = false;
        $data['title'] = language('frontend.forgot.title');
        $data['name'] = language('frontend.forgot.name');
        $data['keywords'] = language('frontend.forgot.keywords');
        $data['description'] = language('frontend.forgot.description');
        $data['message'] = language('frontend.forgot.error');

        return view('frontend.cabinet.error', compact('data'));

    } // public function success


    public function passwordresets(Request $request)
    {

        $data = [];

        $token = stripinput($request->token);
        if (!empty($token)) {
            $reset = PasswordResets::getByToken($token);
        } else {
            $reset = null;
        }
        if ($reset) {

            $data['email'] = $reset->email;
            $data['token'] = $token;

            return view('frontend.cabinet.passwordresets', compact('data'));

        } else {

            return redirect()->route('frontend.forgot.error');
        }
    }


    public function passwordresetstore(PasswordResetsRequest $request)
    {

        $email = stripinput($request->email);
        $token = stripinput($request->token);
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        if (!empty($token)) {
            $reset = PasswordResets::getByToken($token);
        } else {
            $reset = null;
        }
        if ($reset) {

            $user = User::getByEmail($reset->email);
            if ($user) {

                if (!empty($password)) {
                    $user->password = bcrypt($password);
                }
                $user->save();

                PasswordResets::where('email', $reset->email)->delete();



                $toMail = $reset->email;

                $mail_data = [
                    'email' => $reset->email,
                    'password' => $password,
                ];

                Mail::to($toMail)
                    ->send(new PasswordResetsMail($mail_data));



                return redirect()->route('frontend.login.index')->with('success', language('frontend.forgot.success_password_reseted'));
            } else {

                return redirect()->route('frontend.forgot.error');
            }
        } else {

            return redirect()->route('frontend.forgot.error');
        }
    }

}

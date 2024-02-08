<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class ApiController extends Controller
{

    public function login(Request $request)
    {
//        $email = $request->json()->email;
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $user = Auth::user();
            $success['token'] = $user->createToken('login_token')->accessToken;

            return response()->json([
                'success' => $success
            ], 200);

        }

        return response()->json([
            'error' => 'Unauthorized'
        ], 401);


    }

    public function getUser(Request $request)
    {
        return Auth::user();
    }

    public function orders(Request $request)
    {
        return 444;
    }


    public function createSecretKey()
    {
        $secretKey = Str::random(40);
        $client = Passport::client()->forceFill([
            'name' => 'web_token',
            'secret' => $secretKey,
            'redirect' => '',
            'personal_access_client' => 0,
            'password_client' => 0,
            'revoked' => false,
        ]);

        $client->save();

        return response()->json([
            'id' =>  $client->id,
            'secretKey' =>  $secretKey,
        ]);

    }

    public function createTokenForClient(Request $request)
    {


        $client = json_decode(json_encode($this->createSecretKey()),true)['original'];




        $response = Http::asForm()->post(env('APP_URL').'/api/createTokenForClientAccess', [
            'grant_type' => 'client_credentials',
            'client_id' => $client['id'],
            'client_secret' => $client['secretKey'],
            'scope' => '',
        ]);


        return response()->json([
            'id' => $client['id'],
            'secret_key' => $client['secretKey'],
            'token_type' => $response['token_type'],
            'expires_in' => $response['expires_in'],
            'access_token' => $response['access_token'],
        ]);



    }

}

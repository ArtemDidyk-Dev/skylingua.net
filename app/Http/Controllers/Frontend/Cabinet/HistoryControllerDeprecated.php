<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Pay\Pay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{

    public function index(Request $request)
    {
        $user_id = Auth::id();

        $user = User::getParentUser($user_id);
        $auth_user = $user;

        $pays = Pay::getByFreelancerId($user_id, 10);

//        @dd( $pays );

        return view('frontend.cabinet.history', compact(
            'auth_user',
            'user',
            'pays',
        ));

    } // public function login



}

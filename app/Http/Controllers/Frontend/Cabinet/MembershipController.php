<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{

    public function __construct()
    {

    }

    public function freelancer(Request $request)
    {
        $user_id = Auth::id();

        $user = User::getParentUser($user_id);
        $auth_user = $user;


        return view('frontend.dashboard.freelancer.membership', compact(
            'auth_user',
            'user'
        ));
    }

    public function employer(Request $request)
    {
        $user_id = Auth::id();

        $user = User::getParentUser($user_id);
        $auth_user = $user;


        return view('frontend.dashboard.employer.membership-plans', compact(
            'auth_user',
            'user'
        ));
    }


}

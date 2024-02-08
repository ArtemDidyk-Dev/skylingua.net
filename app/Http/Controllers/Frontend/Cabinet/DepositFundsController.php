<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Pay\Pay;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositFundsController extends Controller
{

    public function __construct()
    {

    }

    public function employer(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $getPays = Pay::getByEmployerId($user_id);
        $pays = [];
        if ($getPays) {
            foreach ($getPays as $getPay) {
                $getPay->created_at_view = Carbon::parse($getPay->created_at)->format('M d, Y');
                $getPay->amount_view = $getPay->amount ? number_format($getPay->amount, 2, ".", " ") : 0;
                $pays[] = $getPay;
            }
        }


//        @dd($pays);

        return view('frontend.dashboard.employer.deposit-funds', compact(
            'auth_user',
            'user',
            'getPays',
            'pays'
        ));
    }


}

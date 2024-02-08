<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Notification\Notification;
use App\Models\Notification\NotificationTranslation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NativicationController extends Controller
{

    public function index(Request $request)
    {


        $user_id = Auth::id();

        $user = User::getParentUser($user_id);
        $auth_user = $user;

        $notifications = Notification::getByUserId($user_id, $request->languageID, 10);

//        @dd($notifications);

        return view('frontend.cabinet.nativication', compact(
            'auth_user',
            'user',
            'notifications',
        ));

    }

    public function delete(Request $request)
    {
        $user_id = (int)Auth::id();

        if ($request->data) {
            foreach ($request->data as $nativication_id) {

                Notification::where('id', (int)$nativication_id)
                    ->where('user_id', $user_id)
                    ->delete();

            }
        } else {

            Notification::where('user_id', $user_id)
                ->delete();
        }


        return response()->json(['success' => true], 200);

    }

    public function mark(Request $request)
    {
        $user_id = (int)Auth::id();
        $action = (int)$request->action;


        if ($request->data) {
            foreach ($request->data as $nativication_id) {

                $notifications = Notification::where('id', (int)$nativication_id)
                    ->where('user_id', $user_id)
                    ->first();
                $notifications->status = ($action == 1 ? 1 : 0);
                $notifications->save();

            }
        } else {

            $notifications = Notification::where('user_id', $user_id)
                ->update(['status' => ($action == 1 ? 1 : 0)]);

        }

        $notification_count = Notification::where('user_id', $user_id)
            ->where('status', 0)
            ->count();


        return response()->json([
            'success' => true,
            'count' => $notification_count
            ], 200);

    }



}

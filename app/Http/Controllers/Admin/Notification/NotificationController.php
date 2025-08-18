<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationAddRequest;
use App\Http\Requests\Notification\NotificationEditRequest;
use App\Models\Language\Languages;
use App\Models\Notification\Notification;
use App\Models\Notification\NotificationTranslation;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public $defaultLanguage;
    public $validatorCheck;


    public function __construct()
    {

        //Hansi dil defaultdursa onu caqir
        $this->defaultLanguage = cache('language-defaultID') == null ? Languages::where('default', 1)
            ->first()->id : cache('language-defaultID');

    }

    public function index(Request $request)
    {



        $notifications = Notification::with(array('notificationsTranlations' => function ($query) {
            $query->where('language_id', $this->defaultLanguage);

        }))
            ->with('getUser')
            ->orderBy('id', 'DESC')
            ->paginate(10);



        return view('admin.notification.index', compact('notifications'));
    }


    public function search(Request $request)
    {
        $search = $request->search;

        $notifications = Notification::where('language_id', $this->defaultLanguage)
            ->where('users.name', 'like', '%' . $search . '%')
            ->orWhere('users.email', 'like', '%' . $search . '%')
            ->join('notifications_translations','notifications.id','=','notifications_translations.notification_id')
            ->join('users','notifications.user_id','=','users.id')
            ->orderBy('notifications.id', 'DESC')
            ->select(
                '*',
                'notifications.updated_at as updated_at',
                'notifications.status as notification_status',
            )
            ->paginate(10);




        return view('admin.notification.search', compact('notifications'));
    }


    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $notification = Notification::where('id', $id)->first();
        $data = '';
        $success = '';

        if ($notification) {
            $notification->status = $statusActive;
            $notification->save();

            if ($statusActive == 1) {
                $data = 1;
            } else {
                $data = 0;
            }

            $success = true;
        } else {
            $success = false;

        }


        return response()->json(['success' => $success, 'data' => $data]);
    }



    public function deleteAjax(Request $request)
    {
        $id = $request->id;
        Notification::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }

    public function delete(Request $request)
    {

        $id = intval($request->id);

        Notification::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }

    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }
}

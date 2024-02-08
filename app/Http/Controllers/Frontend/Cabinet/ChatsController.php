<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\CreateChatMail;
use App\Models\Chats\ChatMessages;
use App\Models\Chats\Chats;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ChatsController extends Controller
{

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $user_id = Auth::id();

        if ($request->session()->exists('chat_user_to')) {
            $chat_open = $request->session()->get('chat_user_to');

            $request->session()->forget('chat_user_to');
        } else {
            $chat_open = false;
        }


        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getParentUser($user_id, $user_filter);
        $auth_user = $user;

//        dd($user);

        $chats = [];

        $getChats = Chats::getChats($user_id);

//        @dd($getChats);

        foreach ($getChats as $chat) {
            $diffInDays = \Carbon\Carbon::parse($chat->updated_at)->diffInDays();
            $showDiff = \Carbon\Carbon::parse($chat->updated_at)->diffForHumans();
            if ($diffInDays > 0) {
                $showDiff .= ', ' . \Carbon\Carbon::parse($chat->updated_at)->addDays($diffInDays)->diffInHours() . ' Hours';
            }

            $chats[] = [
                'id' => $chat->id,
                'date' => $showDiff,
                'users_id' => $chat->users_id,
                'role_id' => User::getUser($chat->users_id)->role_id ?? 0,
                'users_name' => $chat->users_name,
                'users_profile_photo' => !empty($chat->users_profile_photo) ? asset('storage/profile/' . $chat->users_profile_photo) : asset('storage/no-photo.jpg'),
                'last_messages' => $chat->last_messages,
                'last_file' => !empty($chat->last_file) ? true : false,
                'total_messages' => $chat->total_messages,
            ];
        } //


        return view('frontend.dashboard.chats', compact(
            'auth_user',
            'user',
            'chats',
            'chat_open'
        ));
    }


    public function createChat(Request $request)
    {
        $user_from = Auth::id();
        $user_to = (int)$request->id;

        $user = User::getUser($user_to);
        if ($user) {
            $chat = Chats::getChat($user_from, $user_to);
            if (!$chat) {
                Chats::createChat($user_from, $user_to);
            }

            $request->session()->put('chat_user_to', $user_to);





            $toMail = setting('email');
            $mailData = [
                'user_from' => Auth::user(),
                'user_to' => $user,
            ];
            Mail::to($toMail)
                ->send(new CreateChatMail( $mailData ));


            return redirect()->route('frontend.dashboard.chats');
        } else {
            return redirect()->back();
        }
    }

    public function deleteChat(Request $request)
    {
        $user_id = Auth::id();
        $chat_id = (int)$request->id;

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getParentUser($user_id, $user_filter);
        if ($user == null) {
            return redirect()->back();
        }
        if ($user->role_id > 2) {
            return redirect()->back();
        }


        $chat = Chats::getChatById($chat_id);
        if ($chat == null) {
            return redirect()->back();
        }

        if ($chat->user_1 != $user_id && $chat->user_2 != $user_id) {
            return redirect()->back();
        }

        Chats::deleteChat($chat_id);

        return redirect()->route('frontend.dashboard.chats');
    }

    public function getMessagesAjax(Request $request)
    {
        $user_from = (int)Auth::id();
        $user_to = (int)$request->user_to;
        $new_message = (int)$request->new_message;


        $data = [];

        $messages = ChatMessages::getMessages($user_from, $user_to, $new_message);
        if ($messages) {
            foreach ($messages as $message) {
                $diffInDays = \Carbon\Carbon::parse($message->created_at)->diffInDays();
                $showDiff = \Carbon\Carbon::parse($message->created_at)->diffForHumans();
                if ($diffInDays > 0) {
                    $showDiff .= ', ' . \Carbon\Carbon::parse($message->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
                }

                $files = [];

                if ($message->file) {
                    $fileArray = explode("|", $message->file);
                    foreach ($fileArray as $file) {

                        $file_url = asset("storage/chats/" . $file);
                        $file = "public/chats/" . $file;
                        $fileInfoPath = pathinfo(public_path($file));

                        $files[] = [
                            'name' => $fileInfoPath['basename'],
                            'size' => bytesToHuman(Storage::size($file)),
                            'lastModified' => date("Y-m-d", Storage::lastModified($file)),
                            'extension' => $fileInfoPath['extension'],
                            'file' => $file_url
                        ];
                    }
                } else {
                    $files = [];
                }

                $data[] = [
                    'message' => html_entity_decode($message->message),
                    'files' => $files,
                    'date' => $showDiff,
                    'users_id' => $message->users_id,
                    'users_name' => $message->users_name,
                    'users_profile_photo' => !empty($message->users_profile_photo) ? asset('storage/profile/' . $message->users_profile_photo) : asset('storage/no-photo.jpg'),
                    'received_sent' => ($message->user_from == $user_from ? "sent" : "received"),
                ];
            }
        }


        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getCountAjax(Request $request)
    {
        $user_from = (int)Auth::id();
        $user_to = $request->user_to;

        $data = [];

        foreach ($user_to as $user_id) {
            $messages = ChatMessages::getCount($user_from, (int)$user_id);
            if ($messages) {
                $data[] = [
                    'user' => (int)$user_id,
                    'count' => (int)$messages
                ];
            } else {
                $data[] = [
                    'user' => (int)$user_id,
                    'count' => 0
                ];
            }
        } // foreach

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getCountNewMessageAjax(Request $request)
    {
        $user_id = (int)Auth::id();

        $data = [];

        $getCount = ChatMessages::getCountNewMessage($user_id);
        if ($getCount) {
            $data = (int)$getCount;
        } else {
            $data = 0;
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function addMessagesAjax(Request $request)
    {
        $user_from = (int)Auth::id();
        $user_to = (int)$request->user_to;
        if ($request->html == true) {
            $message = stripinput($request->message);
        } else {
            $message = stripinput(strip_tags($request->message));
        }
        $file = $request->file;
        $fileNames = [];


        $getChat = Chats::getChat($user_from, $user_to);
        if ($getChat) {
            if ($file) {
                foreach ($file as $fileName) {
                    $fileName = stripinput($fileName);
                    $filePathOld = "public/tmp/" . $user_from . "/" . $fileName;
                    $filePathNew = $getChat->id . "/" . rand() . "/" . $fileName;
                    if (Storage::exists($filePathOld)) {
                        Storage::move($filePathOld, "public/chats/" . $filePathNew);
                        $fileNames[] = $filePathNew;
                    } // if
                } // foreach
            } // if
        } // if

        $fileNames = implode("|", $fileNames);

        $data = [];

        $message = ChatMessages::addMessages($user_from, $user_to, $message, $fileNames);
        if ($message) {
            $diffInDays = \Carbon\Carbon::parse($message->created_at)->diffInDays();
            $showDiff = \Carbon\Carbon::parse($message->created_at)->diffForHumans();
            if ($diffInDays > 0) {
                $showDiff .= ', ' . \Carbon\Carbon::parse($message->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
            }

            if ($message->file) {
                $fileArray = explode("|", $message->file);
                foreach ($fileArray as $file) {

                    $file_url = asset("storage/chats/" . $file);
                    $file = "public/chats/" . $file;
                    $fileInfoPath = pathinfo(public_path($file));

                    $files[] = [
                        'name' => $fileInfoPath['basename'],
                        'size' => bytesToHuman(Storage::size($file)),
                        'lastModified' => date("Y-m-d", Storage::lastModified($file)),
                        'extension' => $fileInfoPath['extension'],
                        'file' => $file_url
                    ];
                }
            } else {
                $files = [];
            }

            $data = [
                'message' => html_entity_decode($message->message),
                'files' => $files,
                'date' => $showDiff,
                'users_id' => $user_from,
                'users_name' => Auth::user()->name,
                'users_profile_photo' => !empty(Auth::user()->profile_photo) ? asset('storage/profile/' . Auth::user()->profile_photo) : asset('storage/no-photo.jpg'),
                'received_sent' => "sent",
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    public function fileUploadAjax(Request $request)
    {
        $user_id = Auth::id();

        $request->validate([
            'filedata' => 'required|mimes:pdf,xlx,csv,doc,docx,jpg,jpeg,png,gif|max:2048',
        ]);


        $fileName = stripinput($request->filedata->getClientOriginalName());
        $request->filedata->move(public_path('storage/tmp/' . $user_id), $fileName);


        $data = [];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    public function fileDeleteAjax(Request $request)
    {
        $user_id = Auth::id();

        $fileName = stripinput($request->file);
        if (isset($request->patch)) {
            $filePatch = stripinput($request->patch);
        } else {
            $filePatch = "tmp/" . $user_id;
        }
        $filePath = "public/" . $filePatch . "/" . $fileName;

        $data = [];

        if (Storage::exists($filePath)) {
            $data['message'] = language('Success');
            Storage::delete($filePath);
        } else {
            $data['message'] = language('File does not exists.');
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


}

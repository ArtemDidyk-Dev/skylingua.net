<?php
namespace App\Http\Controllers\Frontend\Traid;

use App\Models\Chats\ChatMessages;
use App\Models\Chats\Chats;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\CreateChatMail;

trait TraitSendChatInterestingTeacher
{
    public function sendChatInterestingTeacher(Request $request, int $user_from, int $user_to, string $subject)
    {

        $message = language('Hello! I am interested in your language course');
        $chat = Chats::getChat($user_from, $user_to);
        if (!$chat) {
            $toMail = setting('email');
            $user = User::find($user_to);
            $mailData = [
                'user_from' => Auth::user(),
                'user_to' => $user,
            ];
            Mail::to($toMail)
                ->send(new CreateChatMail($mailData));
           Chats::createChat($user_from, $user_to);
           ChatMessages::addMessages($user_from, $user_to, $message);
            if ($subject) {
                ChatMessages::addMessages($user_from, $user_to, $subject);
            }
        }
        if ($subject) {
            ChatMessages::addMessages($user_from, $user_to, $subject);
        }
        $request->session()->put('chat_user_to', $user_to);
        return redirect()->route('frontend.dashboard.chats');
    }

}

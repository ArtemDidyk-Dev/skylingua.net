<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessages extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';
    protected $primaryKey = 'id';
    protected $guarded = [];



    public static function getMessages($user_from, $user_to, $new_message = false)
    {

        $user_from = (int)$user_from;
        $user_to = (int)$user_to;

        $messages = ChatMessages::select(
            'chat_messages.*',
            'users.id as users_id',
            'users.name as users_name',
            'users.profile_photo as users_profile_photo',
        )
            ->leftJoin('users', function ($join) {
                $join->on('chat_messages.user_from', '=', 'users.id');
            })
            ->where(function($q) use ($user_from) {
                $q->where('chat_messages.user_from', $user_from)
                    ->orWhere('chat_messages.user_to', $user_from);
            })
            ->where(function($q) use ($user_to) {
                $q->where('chat_messages.user_from', $user_to)
                    ->orWhere('chat_messages.user_to', $user_to);
            })
            ->orderBy('chat_messages.id', 'ASC')
            ->groupBy('chat_messages.id');

        if($new_message == true) {
            $messages = $messages->where('chat_messages.status', 0);
            $messages = $messages->where('chat_messages.user_from', '!=', $user_from);
        }

        $messages = $messages->get();

        $messages_up = ChatMessages::where('chat_messages.user_from', $user_to)
            ->where('chat_messages.user_to', $user_from)
            ->update(['chat_messages.status' => 1]);

        return $messages;
    }

    public static function getCount($user_from, $user_to)
    {

        $user_from = (int)$user_from;
        $user_to = (int)$user_to;

        $messages = ChatMessages::where(function($q) use ($user_from) {
            $q->where('chat_messages.user_from', $user_from)
                ->orWhere('chat_messages.user_to', $user_from);
        })
        ->where(function($q) use ($user_to) {
            $q->where('chat_messages.user_from', $user_to)
                ->orWhere('chat_messages.user_to', $user_to);
        })
        ->where('chat_messages.status', 0)
        ->where('chat_messages.user_from', '!=', $user_from)
        ->count();

        return $messages;
    }

    public static function getCountNewMessage($user_id)
    {

        $user_id = (int)$user_id;

        $message_count = ChatMessages::where('user_to', $user_id)
            ->where('status', 0)
            ->count();

        return $message_count;
    }


    public static function addMessages($user_from, $user_to, $message, $file = "")
    {

        $chat = Chats::getChat($user_from, $user_to);
        if ($chat) {
            $message = ChatMessages::create([
                'chat_id' => (int)$chat->id,
                'user_from' => $user_from,
                'user_to' => $user_to,
                'message' => $message,
                'file' => $file,
                'status' => 0
            ]);
            if ($message) {

                $chat->updated_at = NOW();
                $chat->save();

                return $message;
            }
        } else {
            return false;
        }
    }

}

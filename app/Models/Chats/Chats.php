<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chats extends Model
{
    use HasFactory;

    protected $table = 'chats';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public static function getChats($user_id)
    {

        $chats = Chats::select(
            'chats.*',
            'users.id as users_id',
            'users.name as users_name',
            'users.profile_photo as users_profile_photo',
//                'chat_messages.message as chat_messages',
            DB::raw("(
                    SELECT chat_messages.message
                    FROM chat_messages
                    WHERE chat_messages.chat_id = chats.id
                    ORDER BY chat_messages.id DESC
                    LIMIT 1
                ) as last_messages"),
            DB::raw("(
                    SELECT chat_messages.file
                    FROM chat_messages
                    WHERE chat_messages.chat_id = chats.id
                    ORDER BY chat_messages.id DESC
                    LIMIT 1
                ) as last_file"),
            DB::raw("(
                    SELECT count(chat_messages.id)
                    FROM chat_messages
                    WHERE chat_messages.chat_id = chats.id
                    AND chat_messages.user_to = " . $user_id . "
                    AND chat_messages.status = 0
                ) as total_messages")
        )
            ->leftJoin('users', function ($join) {
                $join->on('chats.user_1', '=', 'users.id')->orOn('chats.user_2', '=', 'users.id');
            })
//            ->leftJoin('chat_messages', 'chats.id', '=', 'chat_messages.chat_id')
//            ->leftJoin('chat_messages', function ($join) {
//                $join->on('chats.user_1', '=', 'chat_messages.id')->orOn('chats.user_2', '=', 'users.id');
//            })
            ->where(function ($q) use ($user_id) {
                $q->where('chats.user_1', $user_id)
                    ->orWhere('chats.user_2', $user_id);
            })
            ->where('users.id', '!=', $user_id)
            ->orderBy('chats.updated_at', 'DESC')
//            ->groupBy('chats.id')
            ->get();

        return $chats;
    }
    public static function getChatById($id)
    {

        $chat = Chats::where('id', (int)$id)
            ->first();

        return $chat;
    }

    public static function getChat($user_from, $user_to)
    {
        $chat = Chats::where(function ($q) use ($user_from) {
            $q->where('chats.user_1', $user_from)
                ->orWhere('chats.user_2', $user_from);
        })
            ->where(function ($q) use ($user_to) {
                $q->where('chats.user_1', $user_to)
                    ->orWhere('chats.user_2', $user_to);
            })
            ->first();

        return $chat;
    }

    public static function createChat($user_from, $user_to)
    {

        $chat = Chats::create([
            'user_1' => (int)$user_from,
            'user_2' => (int)$user_to,
        ]);

        return $chat;
    }

    public static function deleteChat($id)
    {

        $chat = Chats::where(['id' => (int)$id])
            ->delete();

        return $chat;
    }

}

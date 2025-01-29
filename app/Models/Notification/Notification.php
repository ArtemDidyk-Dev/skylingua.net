<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function notificationsTranlations()
    {
        return $this->hasMany('App\Models\Notification\NotificationTranslation','notification_id','id');
    }

    public function getUser()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }


    public static function addNotification($user_id, $text, $languageID = 1) {

        $notification = Notification::create([
            'user_id' => (int)$user_id,
            'status' => 0
        ]);

        if ($notification) {
            NotificationTranslation::create([
                'notification_id' => $notification->id,
                'language_id' => (int)$languageID,
                'text' => stripinput($text)
            ]);

            return $notification;
        } else {
            return false;
        }
    }

    public static function getNotifications($languageID, $limit = 10) {

        $notifications = Notification::where('language_id', $languageID)
            ->join('notifications_translations', 'notifications.id', '=', 'notifications_translations.notification_id')
            ->orderBy('sort', 'ASC')
            ->limit($limit)
            ->get();

        return $notifications;

    }


    public static function getByUserId($user_id, $languageID, $limit = 10) {

        $notifications = Notification::where('user_id', (int)$user_id)
            ->join('notifications_translations', 'notifications.id', '=', 'notifications_translations.notification_id')
//            ->limit((int)$limit)
            ->orderBy('id', 'DESC')
            ->paginate($limit);
//            ->get();

        return $notifications;

    }

}

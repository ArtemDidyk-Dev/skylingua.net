<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Str;

class Access extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const OPEN_TO_EVERYONE = 'open_to_everyone';
    public const SUBSCRIBERS_ONLY = 'subscribers_only';
    public const SUBSCRIBERS_OR_ONE_TIME_PAYMENT = 'subscribers_or_one_time_payment';
    public const ONE_TIME_PAYMENT_ONLY = 'one_time_payment_only';


    /**
     * Get all access types as an array.
     *
     * @return array
     */
    public static function getAccessTypes(): array
    {
        return [
            self::OPEN_TO_EVERYONE => 'Open to everyone',
            self::SUBSCRIBERS_ONLY => 'Subscribers only',
            self::SUBSCRIBERS_OR_ONE_TIME_PAYMENT => 'Subscribers or one-time payment',
            self::ONE_TIME_PAYMENT_ONLY => 'One-time payment only',
        ];
    }

    /**
     * Get all access types as an array.
     *
     * @return array
     */
    public static function getAccessDefault(): array
    {
        return [
            self::OPEN_TO_EVERYONE => 'Open to everyone',
        ];
    }

    public function freelancer(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Course::class,
            'id',
            'id',
            'course_id',
            'user_id'
        );
    }

    public function getAccessTextAttribute()
    {
        return match ($this->type) {
            self::OPEN_TO_EVERYONE => 'Open to everyone',
            self::SUBSCRIBERS_ONLY => 'Subscribers only',
            self::SUBSCRIBERS_OR_ONE_TIME_PAYMENT => 'Subscribers or one-time payment',
            self::ONE_TIME_PAYMENT_ONLY => 'One-time payment only',
            default => '1'
        };
    }
}

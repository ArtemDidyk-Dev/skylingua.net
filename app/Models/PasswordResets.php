<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResets extends Model
{
    use HasFactory;

    protected $table = 'password_resets';

    protected $fillable = [
        'email',
        'token',
    ];

    protected $hidden = [
        'token',
    ];


    public static function add($request)
    {

        $reset = PasswordResets::create([
            'email' => $request['email'],
            'token' => $request['token']
        ]);

        return $reset;
    }

    public static function getByToken($token)
    {

        $reset = PasswordResets::where('token', $token)
            ->first();

        return $reset;
    }

}

<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public static function getUserNameEmail($id)
    {
        return User::where('id',$id)->first();

    }

}

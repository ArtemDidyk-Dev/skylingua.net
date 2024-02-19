<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ServiceSavaCommentImg implements SaveFile
{
    public function save($file): object|null
    {
        if($file) {
            $ex = $file->getClientOriginalExtension();
            $name = uniqid() . '.' . $ex;
            Storage::putFileAs('public/comments', $file, $name);
            $file->name = "comments/{$name}";
            return $file;
        }
        return null;
    }
}


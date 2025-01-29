<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFile extends Model
{
    protected $table = 'сourse_files';
    use HasFactory;
    protected $fillable = [
        'course_id',
        'path',
        'type',
        'promo',
        'name'
    ];
}

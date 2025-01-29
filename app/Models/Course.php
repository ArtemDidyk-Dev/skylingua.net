<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function access(): HasOne
    {
        return $this->hasOne(Access::class, 'course_id', 'id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(CourseFile::class , 'course_id', 'id');
    }

    public function getDataFormatAttribute()
    {
        return $this->created_at->format('F j, Y');
    }

    public function getShortAttribute()
    {
        $plainText = strip_tags($this->description);
        return Str::limit($plainText, 300);
    }


}

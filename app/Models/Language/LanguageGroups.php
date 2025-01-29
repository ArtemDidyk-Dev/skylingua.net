<?php

namespace App\Models\Language;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageGroups extends Model
{
    use HasFactory;

    protected $table = 'language_groups';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function countPhrase()
    {
        return $this->hasMany('App\Models\Language\LanguagePhrases','language_group_id','id');
    }

}

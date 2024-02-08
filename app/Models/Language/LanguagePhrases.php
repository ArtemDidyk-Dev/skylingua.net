<?php

namespace App\Models\Language;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguagePhrases extends Model
{
    use HasFactory;

    protected $table = 'language_phrases';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function language_groups()
    {
        return $this->belongsTo('App\Models\Language\LanguageGroups','language_group_id','id');
    }

    public function languageGroups()
    {
        return $this->belongsTo('App\Models\Language\LanguageGroups','language_group_id','id')
            ->orderBy('name','ASC');
    }


    public function language_phrase_translations()
    {
        return $this->hasMany('App\Models\Language\LanguagePhraseTranslations','phrase_id','id');
    }


    public function translate()
    {
        return $this->hasMany('App\Models\Language\LanguagePhraseTranslations','phrase_id','id')
            ->orderBy('language_id','ASC');
    }



}

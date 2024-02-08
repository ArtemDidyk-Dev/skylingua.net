<?php

namespace App\Models\Language;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguagePhraseTranslations extends Model
{
    use HasFactory;

    protected $table = 'language_phrase_translations';
    protected $primaryKey = 'id';
    protected $guarded = [];

}

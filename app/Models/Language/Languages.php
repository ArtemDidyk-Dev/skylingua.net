<?php

namespace App\Models\Language;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    use HasFactory;

    protected $table = 'languages';
    protected $primaryKey = 'id';
    protected $guarded = [];



}

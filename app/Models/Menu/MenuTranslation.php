<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuTranslation extends Model
{
    use HasFactory;


    protected $table = 'menu_translations';
    protected $primaryKey = 'id';
    protected $guarded = [];

}

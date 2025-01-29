<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPosition extends Model
{
    use HasFactory;

    protected $table = 'menu_positions';
    protected $primaryKey = 'id';
    protected $guarded = [];

}

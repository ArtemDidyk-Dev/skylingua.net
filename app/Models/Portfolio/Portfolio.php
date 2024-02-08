<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolio';
    protected $primaryKey = 'id';
    protected $guarded = [];



    public static function getByUserId($user_id, $limit = 10) {

        $portfolios = Portfolio::where('user_id', (int)$user_id)
            ->where('approve', 1)
            ->orderBy('id', 'DESC')
            ->paginate($limit);

        return $portfolios;

    }


    public static function getByUserIdOwner($user_id, $limit = 10) {

        $portfolios = Portfolio::where('user_id', (int)$user_id)
            ->orderBy('id', 'DESC')
            ->paginate($limit);

        return $portfolios;

    }


    public static function add($user_id, $data)
    {

        $portfolio = Portfolio::create([
            'user_id' => (int)$user_id,
            'title' => stripinput($data['title']),
            'link' => Str::slug(stripinput($data['link']))
        ]);

        return $portfolio;
    }


}

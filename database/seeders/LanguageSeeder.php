<?php

namespace Database\Seeders;

use App\Models\Language\Languages;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Languages::create([
            'name' => 'English',
            'short_name' => 'Eng',
            'code' => 'en',
            'status' => 1,
            'default' => 1,
            'sort' => 1,
        ]);

    }
}

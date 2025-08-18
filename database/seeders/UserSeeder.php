<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Admin',
            'email' => 'i_behruz19@mail.ru',
            'password' => Hash::make('adminminad'),
            'status' => 1,
        ]);
        $user->syncRoles( 1 ); // Super Admin


        $user2 = User::create([
            'name' => 'Azad',
            'email' => 'azad@azad.az',
            'password' => Hash::make('adminminad'),
            'status' => 1,
        ]);
        $user2->syncRoles( 2 ); // Admin
    }
}

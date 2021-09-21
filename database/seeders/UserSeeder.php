<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([

            // Super Admin
            [
                'id' => '1',
                'name' => 'Administrator',
                'email' => 'admin@system.io',
                'password' => Hash::make('123456'),
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],

        ]);
    }
}

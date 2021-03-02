<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {

            User::insert([
                    [
                        'name'              => 'admin',
                        'email'             => 'admin@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => bcrypt('12345'), // password
                        'remember_token'    => Str::random(10),
                    ],
                    [
                        'name'              => 'Manjurul',
                        'email'             => 'manjurul@gmail.com',
                        'email_verified_at' => now(),
                        'password'          => bcrypt('12345'), // password
                        'remember_token'    => Str::random(10),
                    ]
                ]
            );
        }

    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        User::create([

            'name' => 'Administrator',

            'username' => 'admin',

            'email' => 'admin@gmail.com',

            'password' => '123456',

            'role' => 'admin',
        ]);

        /*
        |--------------------------------------------------------------------------
        | BLOK A
        |--------------------------------------------------------------------------
        */

        for ($i = 1; $i <= 20; $i++) {

            User::create([

                'name' => 'Warga A' . $i,

                'username' => 'delima-a' . $i,

                'email' => 'a' . $i . '@gmail.com',

                'password' => '123456',

                'role' => 'warga',

                'blok' => 'A',

                'nomor_rumah' => $i,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | BLOK B
        |--------------------------------------------------------------------------
        */

        for ($i = 1; $i <= 19; $i++) {

            User::create([

                'name' => 'Warga B' . $i,

                'username' => 'delima-b' . $i,

                'email' => 'b' . $i . '@gmail.com',

                'password' => '123456',

                'role' => 'warga',

                'blok' => 'B',

                'nomor_rumah' => $i,
            ]);
        }
    }
}
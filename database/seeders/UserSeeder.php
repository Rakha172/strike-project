<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'role' => 'admin',
            'phone_number' => '08872354643',
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'member',
            'role' => 'member',
            'phone_number' => '08872415689',
            'email' => 'laladiila537@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'operator',
            'role' => 'operator',
            'phone_number' => '08872415689',
            'email' => 'asansapta@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Rahma Khairani Rangkuti',
            'role' => 'member',
            'phone_number' => '08872354643',
            'email' => 'rhmakhrani@gmail.com',
            'password' => 'password',
        ]);
    }
}

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
            'phone_number' => '080000000000',
            'email' => 'member@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'operator',
            'role' => 'operator',
            'phone_number' => '080000000000',
            'email' => 'operator@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Rahma Khairani Rangkuti',
            'role' => 'member',
            'phone_number' => '08872354643',
            'email' => 'rhmakhrani@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'User1',
            'role' => 'member',
            'phone_number' => '08123456789',
            'email' => 'user1@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'User2',
            'role' => 'member',
            'phone_number' => '08123456788',
            'email' => 'user2@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'User3',
            'role' => 'member',
            'phone_number' => '08123456787',
            'email' => 'user3@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'User4',
            'role' => 'member',
            'phone_number' => '08123456786',
            'email' => 'user4@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'User5',
            'role' => 'member',
            'phone_number' => '08123456785',
            'email' => 'user5@gmail.com',
            'password' => 'password',
        ]);

    }
}

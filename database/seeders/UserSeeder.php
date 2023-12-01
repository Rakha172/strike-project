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
    }
}

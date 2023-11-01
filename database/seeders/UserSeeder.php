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
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'member',
            'role' => 'member',
            'email' => 'member@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'operator',
            'role' => 'operator',
            'email' => 'operator@gmail.com',
            'password' => 'password',
        ]);
    }
}

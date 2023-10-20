<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'name' => 'Strike Maniac',
            'history' => 'Strike Maniac meluncurkan situs web dan aplikasi pertama mereka, memudahkan pelanggan untuk memesan tempat pemancingan secara online. Mereka juga memperkenalkan program loyalitas yang memberikan diskon dan manfaat eksklusif bagi pelanggan setia.',
            'image' => 'logo',
        ]);
    }
}
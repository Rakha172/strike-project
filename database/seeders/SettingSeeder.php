<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $sourcePath = public_path('logo/logo.png');
        File::copy($sourcePath, public_path('logo/logo.png'));

        Setting::create([
            'name' => 'Strike Maniac',
            'location' => 'Indonesia,Jawa Barat,Bandung',
            'history' => 'Strike Maniac meluncurkan situs web dan aplikasi pertama mereka, memudahkan pelanggan untuk memesan tempat pemancingan secara online. Mereka juga memperkenalkan program loyalitas yang memberikan diskon dan manfaat eksklusif bagi pelanggan setia.',
            'logo' => 'logo.png',
        ]);
    }
}

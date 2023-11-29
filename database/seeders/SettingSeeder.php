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
        $sourcePath = public_path('img/logo.png');
        File::copy($sourcePath, public_path('logo/logo.png'));

        Setting::create([
            'name' => 'Strike',
            'location' => 'Indonesia,Jawa Barat,Bandung',
            'history' => 'Strike Maniac meluncurkan situs web dan aplikasi pertama mereka, memudahkan pelanggan untuk memesan tempat pemancingan secara online. Mereka juga memperkenalkan program loyalitas yang memberikan diskon dan manfaat eksklusif bagi pelanggan setia.',
            'logo' => 'logo.png',
            'slogan' => 'Menyediakan Tempat Pemancingan Terbaik Untuk Anda.',
            'desc' => ' Untuk anda yang mempunyai hobi memancing, kami menyediakan kolam
            pemancingan luas yang berisikan berbagai jenis ikan seperti Ikan Mas (Karper),
            Bawal, Gurame, Mujair, dan Patin di mana anda dapat menyalurkan hobie sepuas hati.',
            'phone' => '1234567890',
            'email' => 'strike@gmail.com',
            'sender' => '6282128078893',
            'endpoint' => 'http://wag.cigs.web.id/send-message',
            'api_key' => 'ZMNgdCuH1Vi0OCQ6Recg8ZB9UPy68B',
        ]);
    }
}

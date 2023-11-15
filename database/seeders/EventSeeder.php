<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'name' => 'Galatama',
            'image' => 'logo/logo.png',
            'price' => '150000',
            'total_booth' => '10',
            'event_date' => '2023-12-12',
            'location' => 'Indonesia,Jawa Barat,Bandung',
            'description' => 'Galatama adalah istilah dalam kolam pemancingan atau khusus diperuntukan dalam perlombaan memancing. Istilah ini diambil dari Liga Sepakbola Utama semi profesional, sebelum diubah menjadi Liga Indonesia.',
            'start' => '08:00:00',
            'end' => '17:00:00',
            'qualification' => 'weight',
        ]);

    }
}

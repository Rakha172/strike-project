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
            'image' => 'logo',
            'price' => 'Rp.150.000',
            'total_booth' => '10',
            'event_date' => '2023-12-12',
            'location' => 'Indonesia,Jawa Barat,Bandung',
            'description' => 'Galatama adalah istilah dalam kolam pemancingan atau khusus diperuntukan dalam perlombaan memancing. Istilah ini di ambil dari Liga Sepakbola Utama semi profesial, sebelom diubah menjadi Liga Indonesia.',

        ]);
    }
}

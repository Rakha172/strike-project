<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class EventSeeder extends Seeder {
    public function run(): void {
        Event::create([
            'name' => 'Galatama',
            'image' => 'logo/logo.png',
            'price' => '150000',
            'total_booth' => '10',
            'event_date' => '2023-12-08',
            'location' => 'Indonesia,Jawa Barat,Bandung',
            'description' => 'Galatama adalah istilah dalam kolam pemancingan atau khusus diperuntukan dalam perlombaan memancing. Istilah ini diambil dari Liga Sepakbola Utama semi profesional, sebelum diubah menjadi Liga Indonesia.',
            'start' => '08:00:00',
            'end' => '17:00:00',
            'qualification' => 'weight',
        ]);

        Event::create([
            'name' => 'Malam Megah Dago Pakar',
            'image' => 'logo/p1.jpeg',
            'price' => '200000',
            'total_booth' => '3',
            'event_date' => '2023-12-08',
            'location' => 'Indonesia,Jawa Barat,Bandung',
            'description' => 'Galatama adalah istilah dalam kolam pemancingan atau khusus diperuntukan dalam perlombaan memancing. Istilah ini diambil dari Liga Sepakbola Utama semi profesional, sebelum diubah menjadi Liga Indonesia.',
            'start' => '08:00:00',
            'end' => '17:00:00',
            'qualification' => 'quantity',
        ]);
        Event::create([
            'name' => 'Runa Pemancingan Seru Berkah ',
            'image' => 'logo/p2.jpeg',
            'price' => '250000',
            'total_booth' => '4',
            'event_date' => '2023-12-08',
            'location' => 'Indonesia,Jawa Barat,Bandung',
            'description' => 'Galatama adalah istilah dalam kolam pemancingan atau khusus diperuntukan dalam perlombaan memancing. Istilah ini diambil dari Liga Sepakbola Utama semi profesional, sebelum diubah menjadi Liga Indonesia.',
            'start' => '08:00:00',
            'end' => '17:00:00',
            'qualification' => 'combined',
        ]);

        Event::create([
            'name' => 'Fishing Contest',
            'image' => 'logo/p3.jpeg',
            'price' => '300000',
            'total_booth' => '2',
            'event_date' => '2023-12-08',
            'location' => 'Indonesia,Jawa Barat,Bandung',
            'description' => 'Galatama adalah istilah dalam kolam pemancingan atau khusus diperuntukan dalam perlombaan memancing. Istilah ini diambil dari Liga Sepakbola Utama semi profesional, sebelum diubah menjadi Liga Indonesia.',
            'start' => '08:00:00',
            'end' => '17:00:00',
            'qualification' => 'weight_quantity',
        ]);

    }
}

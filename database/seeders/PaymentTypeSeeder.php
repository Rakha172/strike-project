<?php

namespace Database\Seeders;

use App\Models\PaymentTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentTypes::create([
            'name' => 'Gopay',
            'owner' => 'Rafly',
            'account_number' => '087835231949',
            'username' => 'Rafly',
            'status' => '1'
        ]);
    }
}

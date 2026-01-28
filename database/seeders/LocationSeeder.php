<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['location_name' => 'Stadion Utama'],
            ['location_name' => 'Galeri Seni Kota'],
            ['location_name' => 'Taman Kota'],
        ];

        foreach ($locations as $location) {
            Location::create(['location_name' => $location['location_name']]);
        }
    }
}

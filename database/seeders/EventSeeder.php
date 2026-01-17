<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'user_id' => 1,
                'title' => 'Konser Musik Rock',
                'description' => 'Nikmati malam penuh energi dengan band rock terkenal.',
                'date_time' => '2024-08-15 19:00:00',
                'location' => 'Stadion Utama',
                'category_id' => 1,
                'image' => 'konser_rock.jpg',
            ],
            [
                'user_id' => 1,
                'title' => 'Pameran Seni Kontemporer',
                'description' => 'Jelajahi karya seni modern dari seniman lokal dan internasional.',
                'date_time' => '2024-09-10 10:00:00',
                'location' => 'Galeri Seni Kota',
                'category_id' => 2,
                'image' => 'pameran_seni.jpg',
            ],
            [
                'user_id' => 1,
                'title' => 'Festival Makanan Internasional',
                'description' => 'Cicipi berbagai hidangan lezat dari seluruh dunia.',
                'date_time' => '2024-10-05 12:00:00',
                'location' => 'Taman Kota',
                'category_id' => 3,
                'image' => 'festival_makanan.jpg',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}

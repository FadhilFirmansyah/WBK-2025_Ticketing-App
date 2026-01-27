<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticket_types = [
            [
                'name' => "Tiket Reguler"
            ],
            [
                'name' => "VIP"
            ],
            [
                'name' => "Early Bird"
            ]
        ];

        foreach ($ticket_types as $ticket_type) {
            TicketType::create(['name' => $ticket_type['name']]);
        }
    }
}

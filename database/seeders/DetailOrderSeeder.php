<?php

namespace Database\Seeders;

use App\Models\DetailOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order_details = [
            [
                'order_id' => 1,
                'ticket_id' => 1,
                'amount' => 1,
                'subtotal_price' => 1500000,
            ],
            [
                'order_id' => 2,
                'ticket_id' => 3,
                'amount' => 1,
                'subtotal_price' => 200000,
            ],
        ];
        
        foreach ($order_details as $detail) {
            DetailOrder::create($detail);
        }
    }
}

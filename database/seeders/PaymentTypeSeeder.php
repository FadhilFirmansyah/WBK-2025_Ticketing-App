<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_types = [
            [
                'name' => "Transfer"
            ],
            [
                'name' => "E-Wallet"
            ],
            [
                'name' => "Cash"
            ]
        ];

        foreach ($payment_types as $payment_type) {
            PaymentType::create(['name' => $payment_type['name']]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Fahmiansah',
                'account_name' => 'Fahmiansah',
                'account_number' => '032223 3832398 23828',
                'bank' => 'BCA',
                'image' => '8UKXfbY3Z46BKxBgDmOT.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Anton Wardana',
                'account_name' => 'Anton Wardana',
                'account_number' => '073823 8938293 23839',
                'bank' => 'BRI',
                'image' => 'AKLkGstCWJmwVdBghlax.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('payment_methods')->insert($paymentMethods);
    }
}

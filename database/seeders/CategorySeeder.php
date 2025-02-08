<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Perawatan Wajah',
                'icon' => 'a2cCMmO5DAHWRAbbgIrh.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perawatan Tubuh',
                'icon' => 'GsTzEhaDAHB0cldNRQK2.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perawatan Rambut',
                'icon' => 'G35o8ZBIWvIDKPjyYwfC.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Makeup',
                'icon' => 'M0I9vr7ijBUx10CIChQO.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Parfum',
                'icon' => 'MWnbLsZvUUniWCNYX5K3.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Suplemen Kecantikan',
                'icon' => 'BWW95NdLfinp8wfkgfxi.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alat Kecantikan',
                'icon' => 'MWnbLsZvUUniWCNYX5K3.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paket Bundling',
                'icon' => 'GsTzEhaDAHB0cldNRQK2.png',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'image' => '5R1yE4yPIcicUdj0RUId.jpg',
                'title' => null,
                'url' => 'http://127.0.0.1:8000/detail-product/5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'Q1xOMFxohdGZzqH7dipC.jpg',
                'title' => 'Tips Perawatan Kulit untuk Pemula',
                'url' => 'http://127.0.0.1:8000/product/search',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'pSv3H94ec3hlgZnpjmhD.jpg',
                'title' => null,
                'url' => 'http://127.0.0.1:8000/detail-product/1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('banners')->insert($banners);
    }
}

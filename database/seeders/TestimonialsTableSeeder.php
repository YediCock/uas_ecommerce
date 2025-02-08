<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('testimonials')->insert([
            [
                'name' => 'John Doe',
                'image' => 'eeGcsEKt0JPxDUSNQtPU.jpg',
                'desc' => 'Great service, very satisfied with the product quality! Great service, very satisfied with the product quality!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'image' => 'KJENvAZR6YY7t3R0qC5s.jpg',
                'desc' => 'The customer support was excellent and the delivery was fast. Great service, very satisfied with the product quality!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Johnson',
                'image' => 'WsOCmD68qu2KFeAv0Sbp.jpg',
                'desc' => 'Amazing experience, the team was very helpful throughout the process. Great service, very satisfied with the product quality!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Michael Brown',
                'image' => 'eeGcsEKt0JPxDUSNQtPU.jpg',
                'desc' => 'The product exceeded my expectations, I highly recommend this store. Great service, very satisfied with the product quality!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emily Davis',
                'image' => 'KJENvAZR6YY7t3R0qC5s.jpg',
                'desc' => 'Quick response time and fantastic product. I am a happy customer. Great service, very satisfied with the product quality!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chris Wilson',
                'image' => 'WsOCmD68qu2KFeAv0Sbp.jpg',
                'desc' => 'This was my best online shopping experience so far. Everything was perfect. Great service, very satisfied with the product quality!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sophia Martinez',
                'image' => 'eeGcsEKt0JPxDUSNQtPU.jpg',
                'desc' => 'I absolutely love the product, and the packaging was beautiful. Great service, very satisfied with the product quality!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Lee',
                'image' => 'KJENvAZR6YY7t3R0qC5s.jpg',
                'desc' => 'Great value for the price, will definitely purchase again. Great service, very satisfied with the product quality!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

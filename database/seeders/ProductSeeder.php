<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 4,
                'type' => 'simple',
                'name' => 'Pelembab Wajah & Tubuh',
                'price' => 150000,
                'weight' => 200,
                'desc' => '<div>Netto: 10ml<br><br></div><div>Ca kuku yang sangat berpigmen dan tahan lama yang hadir dalam berbagai warna dan sentuhan akhir sesuai dengan kebutuhan Anda. Sikat dirancang secara ergonomis untuk bekerja dengan bentuk kuku dan juga lebar dan rata untuk meminimalkan jumlah goresan yang dibutuhkan.<br><br></div><div><strong>Keunggulan:</strong><br>1. Tahan lama Lebih tahan dan merata dengan warna yang lebih terang dan glossy.<br>2. Cepat Kering Cepat kering membuat penggunaan pewarna kuku lebih mudah<br>3. Variasi warna untuk berbagai skin tone kulit Warna yang trendi yang tampak cantik untuk tone warm dan cool untuk membuat berbagai gaya kuku.<br><br></div><div><strong>[Cara Penggunaan]</strong><br>1. Aplikasikan Piece Matching Nails Care Base coat pada kuku<br>2. Aplikasikan warna kuku<br>3. Aplikasikan Piece Matching Nails Care Shine Top Coat untuk hasil tahan lama<br><br></div><div>&nbsp;</div>',
                'point' => 50,
                'status' => 'active',
                'img_thumbnail' => 'xVF0g0L970to5IKOgH1T.jpg',
                'is_popular' => 'popular',
                'discount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'type' => 'attribute',
                'name' => 'New Piece Matching Nails Lacquer | Kuteks',
                'price' => 55000,
                'weight' => 200,
                'desc' => '<div><strong>Netto:</strong> 10ml<br><br></div><div>Cat kuku yang sangat berpigmen dan tahan lama yang hadir dalam berbagai warna dan sentuhan akhir sesuai dengan kebutuhan Anda. Sikat dirancang secara ergonomis untuk bekerja dengan bentuk kuku dan juga lebar dan rata untuk meminimalkan jumlah goresan yang dibutuhkan.<br><br></div><div><strong>Keunggulan:</strong><br>1. Tahan lama Lebih tahan dan merata dengan warna yang lebih terang dan glossy.<br>2. Cepat Kering Cepat kering membuat penggunaan pewarna kuku lebih mudah<br>3. Variasi warna untuk berbagai skin tone kulit Warna yang trendi yang tampak cantik untuk tone warm dan cool untuk membuat berbagai gaya kuku.<br><br></div><div><strong>[Cara Penggunaan]</strong><br>1. Aplikasikan Piece Matching Nails Care Base coat pada kuku<br>2. Aplikasikan warna kuku<br>3. Aplikasikan Piece Matching Nails Care Shine Top Coat untuk hasil tahan lama<br><br></div><div>&nbsp;</div>',
                'point' => 40,
                'status' => 'active',
                'img_thumbnail' => 'wzRYGJ3L1hGDusJLBvyA.jpg',
                'is_popular' => 'popular',
                'discount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 5,
                'type' => 'attribute',
                'name' => 'PEKO Water Drop Tint Bomb',
                'price' => 50000,
                'weight' => 200,
                'desc' => '<div><strong>Netto: 50ml&nbsp;</strong><br><br></div><div>Cat kuku yang sangat berpigmen dan tahan lama yang hadir dalam berbagai warna dan sentuhan akhir sesuai dengan kebutuhan Anda. Sikat dirancang secara ergonomis untuk bekerja dengan bentuk kuku dan juga lebar dan rata untuk meminimalkan jumlah goresan yang dibutuhkan.<br><br></div><div><strong>Keunggulan:</strong><br>1. Tahan lama Lebih tahan dan merata dengan warna yang lebih terang dan glossy.<br>2. Cepat Kering Cepat kering membuat penggunaan pewarna kuku lebih mudah<br>3. Variasi warna untuk berbagai skin tone kulit Warna yang trendi yang tampak cantik untuk tone warm dan cool untuk membuat berbagai gaya kuku.<br><br></div><div><strong>[Cara Penggunaan]</strong><br>1. Aplikasikan Piece Matching Nails Care Base coat pada kuku<br>2. Aplikasikan warna kuku<br>3. Aplikasikan Piece Matching Nails Care Shine Top Coat untuk hasil tahan lama<br><br></div><div>&nbsp;</div>',
                'point' => 30,
                'status' => 'active',
                'img_thumbnail' => 'mW8TWIR3AqSHvN6LjdGC.png',
                'is_popular' => 'popular',
                'discount' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 5,
                'type' => 'attribute',
                'name' => 'PEKO Tint Bomb',
                'price' => 90000,
                'weight' => 200,
                'desc' => '<div><strong>Netto: 10ml&nbsp;</strong><br><br></div><div>Cat kuku yang sangat berpigmen dan tahan lama yang hadir dalam berbagai warna dan sentuhan akhir sesuai dengan kebutuhan Anda. Sikat dirancang secara ergonomis untuk bekerja dengan bentuk kuku dan juga lebar dan rata untuk meminimalkan jumlah goresan yang dibutuhkan.<br><br></div><div><strong>Keunggulan:</strong><br>1. Tahan lama Lebih tahan dan merata dengan warna yang lebih terang dan glossy.<br>2. Cepat Kering Cepat kering membuat penggunaan pewarna kuku lebih mudah<br>3. Variasi warna untuk berbagai skin tone kulit Warna yang trendi yang tampak cantik untuk tone warm dan cool untuk membuat berbagai gaya kuku.<br><br></div><div><strong>[Cara Penggunaan]</strong><br>1. Aplikasikan Piece Matching Nails Care Base coat pada kuku<br>2. Aplikasikan warna kuku<br>3. Aplikasikan Piece Matching Nails Care Shine Top Coat untuk hasil tahan lama<br><br></div><div>&nbsp;</div>',
                'point' => 20,
                'status' => 'active',
                'img_thumbnail' => 'J9m5hR2tYSn3n7lLLSll.png',
                'is_popular' => 'popular',
                'discount' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 7,
                'type' => 'attribute',
                'name' => 'Piece Matching Nails',
                'price' => 50000,
                'weight' => 200,
                'desc' => '<div><strong>Netto:</strong> 10ml<br><br></div><div>Cat kuku yang sangat berpigmen dan tahan lama yang hadir dalam berbagai warna dan sentuhan akhir sesuai dengan kebutuhan Anda. Sikat dirancang secara ergonomis untuk bekerja dengan bentuk kuku dan juga lebar dan rata untuk meminimalkan jumlah goresan yang dibutuhkan.<br><br></div><div><strong>Keunggulan:</strong><br>1. Tahan lama Lebih tahan dan merata dengan warna yang lebih terang dan glossy.<br>2. Cepat Kering Cepat kering membuat penggunaan pewarna kuku lebih mudah<br>3. Variasi warna untuk berbagai skin tone kulit Warna yang trendi yang tampak cantik untuk tone warm dan cool untuk membuat berbagai gaya kuku.<br><br></div><div><strong>[Cara Penggunaan]</strong><br>1. Aplikasikan Piece Matching Nails Care Base coat pada kuku<br>2. Aplikasikan warna kuku<br>3. Aplikasikan Piece Matching Nails Care Shine Top Coat untuk hasil tahan lama</div>',
                'point' => 30,
                'status' => 'active',
                'img_thumbnail' => 'ytmrahEdoHcHsQENXgOY.jpg',
                'is_popular' => 'notpopular',
                'discount' => 55,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 7,
                'type' => 'attribute',
                'name' => 'Piece Matching Cat Kuku',
                'price' => 80000,
                'weight' => 200,
                'desc' => '<div><strong>Netto: </strong>220m<br><br></div><div>Cat kuku yang sangat berpigmen dan tahan lama yang hadir dalam berbagai warna dan sentuhan akhir sesuai dengan kebutuhan Anda. Sikat dirancang secara ergonomis untuk bekerja dengan bentuk kuku dan juga lebar dan rata untuk meminimalkan jumlah goresan yang dibutuhkan.<br><br></div><div><strong>Keunggulan:</strong><br>1. Tahan lama Lebih tahan dan merata dengan warna yang lebih terang dan glossy.<br>2. Cepat Kering Cepat kering membuat penggunaan pewarna kuku lebih mudah<br>3. Variasi warna untuk berbagai skin tone kulit Warna yang trendi yang tampak cantik untuk tone warm dan cool untuk membuat berbagai gaya kuku.<br><br></div><div><strong>[Cara Penggunaan]</strong><br>1. Aplikasikan Piece Matching Nails Care Base coat pada kuku<br>2. Aplikasikan warna kuku<br>3. Aplikasikan Piece Matching Nails Care Shine Top Coat untuk hasil tahan lama<br><br></div><div>&nbsp;</div>',
                'point' => 25,
                'status' => 'active',
                'img_thumbnail' => 'jr5DwlfWR3R19O5VcAlb.jpg',
                'is_popular' => 'notpopular',
                'discount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 6,
                'type' => 'simple',
                'name' => 'Lotion Intensive Moisturizing',
                'price' => 160000,
                'weight' => 200,
                'desc' => '<div><strong>Netto: 10ml</strong></div><div>Cat kuku yang sangat berpigmen dan tahan lama yang hadir dalam berbagai warna dan sentuhan akhir sesuai dengan kebutuhan Anda. Sikat dirancang secara ergonomis untuk bekerja dengan bentuk kuku dan juga lebar dan rata untuk meminimalkan jumlah goresan yang dibutuhkan.<br><br></div><div><strong>Keunggulan:</strong><br>1. Tahan lama Lebih tahan dan merata dengan warna yang lebih terang dan glossy.<br>2. Cepat Kering Cepat kering membuat penggunaan pewarna kuku lebih mudah<br>3. Variasi warna untuk berbagai skin tone kulit Warna yang trendi yang tampak cantik untuk tone warm dan cool untuk membuat berbagai gaya kuku.<br><br></div><div><strong>[Cara Penggunaan]</strong><br>1. Aplikasikan Piece Matching Nails Care Base coat pada kuku<br>2. Aplikasikan warna kuku<br>3. Aplikasikan Piece Matching Nails Care Shine Top Coat untuk hasil tahan lama<br><br></div><div>&nbsp;</div>',
                'point' => 30,
                'status' => 'active',
                'img_thumbnail' => 'wj2b368e6Zau9wuuAqyn.jpg',
                'is_popular' => 'notpopular',
                'discount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 6,
                'type' => 'simple',
                'name' => 'Aloe 97% Soothing Lotion',
                'price' => 200000,
                'weight' => 200,
                'desc' => '<div><strong>Netto : 20m</strong><br><br></div><div>Cat kuku yang sangat berpigmen dan tahan lama yang hadir dalam berbagai warna dan sentuhan akhir sesuai dengan kebutuhan Anda. Sikat dirancang secara ergonomis untuk bekerja dengan bentuk kuku dan juga lebar dan rata untuk meminimalkan jumlah goresan yang dibutuhkan.<br><br></div><div><strong>Keunggulan:</strong><br>1. Tahan lama Lebih tahan dan merata dengan warna yang lebih terang dan glossy.<br>2. Cepat Kering Cepat kering membuat penggunaan pewarna kuku lebih mudah<br>3. Variasi warna untuk berbagai skin tone kulit Warna yang trendi yang tampak cantik untuk tone warm dan cool untuk membuat berbagai gaya kuku.<br><br></div><div><strong>[Cara Penggunaan]</strong><br>1. Aplikasikan Piece Matching Nails Care Base coat pada kuku<br>2. Aplikasikan warna kuku<br>3. Aplikasikan Piece Matching Nails Care Shine Top Coat untuk hasil tahan lama<br><br></div><div>&nbsp;</div>',
                'point' => 30,
                'status' => 'active',
                'img_thumbnail' => 'mfovXMeaidq0I51XG6tb.png',
                'is_popular' => 'notpopular',
                'discount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 8,
                'type' => 'simple',
                'name' => 'Masker Wajah Adem',
                'price' => 20000,
                'weight' => 200,
                'desc' => '<div><strong>Netto: 20m</strong><br><br></div><div>Masker yang mengandung Makgeolli. Makgeolli adalah minuman beralkohol<br>tradisional dari Korea yang biasanya di minum oleh petani di Korea pada<br>zaman dahulu. Minuman ini dibuat dari fermentasi beras yang sudah dimasak<br>menjadi nasi. Kadar alkoholnya juga lebih rendah Soju, yaitu sekitar 6<br>sampai 7%.<br><br>Berfungsi untuk mencerahkan dan melembabkan kulit wajah.<br><br></div><div><strong>[Cara penggunaan]</strong> Aplikasikan pada wajah, biarkan selama lebih kurang 15-20<br>menit dan tepuk untuk membantu penyerapan.</div>',
                'point' => 30,
                'status' => 'active',
                'img_thumbnail' => '3Wx1xonLN1LNCJMIGm3e.jpg',
                'is_popular' => 'notpopular',
                'discount' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 8,
                'type' => 'simple',
                'name' => 'Masker Wajah Pria',
                'price' => 30000,
                'weight' => 200,
                'desc' => '<div><strong>Netto:20ml</strong><br><br></div><div>Masker yang mengandung Makgeolli. Makgeolli adalah minuman beralkohol<br>tradisional dari Korea yang biasanya di minum oleh petani di Korea pada<br>zaman dahulu. Minuman ini dibuat dari fermentasi beras yang sudah dimasak<br>menjadi nasi. Kadar alkoholnya juga lebih rendah Soju, yaitu sekitar 6<br>sampai 7%.<br><br>Berfungsi untuk mencerahkan dan melembabkan kulit wajah.<br><br></div><div><strong>[Cara penggunaan]</strong> Aplikasikan pada wajah, biarkan selama lebih kurang 15-20<br>menit dan tepuk untuk membantu penyerapan.</div>',
                'point' => 40,
                'status' => 'active',
                'img_thumbnail' => 'OgexZqoMtBIjvEdsUCSP.png',
                'is_popular' => 'notpopular',
                'discount' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'type' => 'simple',
                'name' => 'Losen tubuh',
                'price' => 13000,
                'weight' => 200,
                'desc' => '<div><strong>Netto: 2m</strong><br><br></div><div>Masker yang mengandung Makgeolli. Makgeolli adalah minuman beralkohol<br>tradisional dari Korea yang biasanya di minum oleh petani di Korea pada<br>zaman dahulu. Minuman ini dibuat dari fermentasi beras yang sudah dimasak<br>menjadi nasi. Kadar alkoholnya juga lebih rendah Soju, yaitu sekitar 6<br>sampai 7%.<br><br>Berfungsi untuk mencerahkan dan melembabkan kulit wajah.<br><br></div><div><strong>[Cara penggunaan]</strong> Aplikasikan pada wajah, biarkan selama lebih kurang 15-20<br>menit dan tepuk untuk membantu penyerapan.</div>',
                'point' => 50,
                'status' => 'active',
                'img_thumbnail' => '0pM3TNN0X9hmPT4OGRzv.jpg',
                'is_popular' => 'notpopular',
                'discount' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}

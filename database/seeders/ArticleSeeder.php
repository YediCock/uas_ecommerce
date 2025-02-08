<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'name' => 'Panduan Perawatan Kulit Wajah untuk Pemula',
                'desc' => 'Artikel ini membahas langkah-langkah dasar dalam merawat kulit wajah bagi pemula, mulai dari pembersihan hingga penggunaan sunscreen.  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?',
                'url_yt' => 'https://www.youtube.com/watch?v=s1wBdcNXdCM',
                'img_thumbnail' => '2qasFco9G3t21iDJHCF3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '5 Tips Memilih Skincare Sesuai Jenis Kulit',
                'desc' => 'Tips dan trik untuk memilih produk skincare yang sesuai dengan jenis kulit seperti kulit kering, berminyak, atau kombinasi.  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?',
                'url_yt' => 'https://www.youtube.com/watch?v=s1wBdcNXdCM',
                'img_thumbnail' => '8p27pY9xfefJ2iSJW5Vg.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manfaat Hyaluronic Acid dalam Skincare',
                'desc' => 'Hyaluronic acid dikenal sebagai bahan yang mampu menghidrasi kulit secara maksimal. Cari tahu lebih lanjut mengenai manfaatnya.  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?  terdekat. Tidak terkecuali dengan rahasia kecantikan orang Korea yang sering membuat banyak orang penasaran. Bagaimana tidak?',
                'url_yt' => null,
                'img_thumbnail' => 'iKXH1NwViN7K4pLZruUa.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('articles')->insert($articles);
    }
}

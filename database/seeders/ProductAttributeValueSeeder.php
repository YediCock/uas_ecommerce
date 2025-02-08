<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductAttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productAttributeValues = [
            [
                'product_id' => 2,
                'attribute_value_id' => 1, 
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'attribute_value_id' => 2,
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'attribute_value_id' => 4,
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'attribute_value_id' => 5,
                'price' => 5000,
                'weight' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'attribute_value_id' => 1, 
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'attribute_value_id' => 2,
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'attribute_value_id' => 1, 
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'attribute_value_id' => 2, 
                'price' => 10000,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'attribute_value_id' => 3, 
                'price' => 20000,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'attribute_value_id' => 1, 
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'attribute_value_id' => 2, 
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'attribute_value_id' => 3, 
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 6,
                'attribute_value_id' => 2, 
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 6,
                'attribute_value_id' => 3, 
                'price' => 0,
                'weight' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('product_attribute_values')->insert($productAttributeValues);
    }
}

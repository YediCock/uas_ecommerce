<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    // Accessor untuk menguraikan atribut JSON
    public function getAttributesAttribute($value)
    {    
        // Pastikan value adalah string JSON yang valid sebelum decode
        if (is_string($value)) {
            $decoded = json_decode($value, true);
        } else {
            return [];
        }
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }
    
        // Pastikan hasil decode adalah array
        if (!is_array($decoded)) {
            return [];
        }
    
        return $decoded;
    }
    // Menghitung harga tambahan dari atribut
    public function calculateAdditionalPrice($attributes)
    {
        // Decode attributes jika belum dalam bentuk array
        if (is_string($attributes)) {
            $attributes = json_decode($attributes, true);
        }

        // Pastikan attributes adalah array
        if (!is_array($attributes)) {
            return 0;
        }

        $additionalPrice = 0;
        foreach ($attributes as $attribute) {
            if (isset($attribute['additional_price']) && is_numeric($attribute['additional_price'])) {
                $additionalPrice += $attribute['additional_price'];
            }
        }

        return $additionalPrice;
    }
    public function calculateTotalPrice($basePrice, $attributes)
    {
        // Decode attributes jika belum dalam bentuk array
        if (is_string($attributes)) {
            $attributes = json_decode($attributes, true);
        }
    
        // Pastikan attributes adalah array
        if (!is_array($attributes)) {
            return $basePrice;
        }
        
        // Hitung harga tambahan dari atribut
        $additionalPrice = 0;
        foreach ($attributes as $attribute) {
            if (isset($attribute['additional_price']) && is_numeric($attribute['additional_price'])) {
                $additionalPrice += $attribute['additional_price'];
            }
        }
    
        // Total harga adalah harga dasar ditambah harga tambahan
        $totalPrice = $basePrice + $additionalPrice;
    
        // Cek apakah produk memiliki diskon
        if ($this->getProduct->discount) {
            $discount = $this->getProduct->discount / 100;
            $totalPrice = $totalPrice * (1 - $discount);
        }
        
        return $totalPrice;
    }
}

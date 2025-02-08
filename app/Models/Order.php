<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getCart()
    {
        return $this->hasMany(Cart::class);
    }
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('customer_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('phone', 'LIKE', '%' . $keyword . '%')
            ->orWhere('final_price', 'LIKE', '%' . $keyword . '%')
            ->orWhere('track_number', 'LIKE', '%' . $keyword . '%')
            ->orWhere('status', 'LIKE', '%' . $keyword . '%');
        });
    }
    public function calculateTotalPointsIN()
    {
        $totalPoints = 0;
        foreach ($this->getCart as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $totalPoints += $product->point * $item->quantity;
            }
        }
        return $totalPoints;
    }
}

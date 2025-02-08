<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('type', 'LIKE', '%' . $keyword . '%')
            ->orWhere('price', 'LIKE', '%' . $keyword . '%')
            ->orWhere('is_popular', 'LIKE', '%' . $keyword . '%')
            ->orWhere('point', 'LIKE', '%' . $keyword . '%')
            ->orWhere('status', 'LIKE', '%' . $keyword . '%');
        });
    }
    public function getProductAttributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id');
    }
    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function getAsset()
    {
        return $this->hasMany(Asset::class, 'product_id')->where('type', 'product');
    }
    public function getAttributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_id', 'attribute_value_id');
    }
}

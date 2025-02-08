<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('name', 'LIKE', '%' . $keyword . '%');
        });
    }
    public function getAsset()
    {
        return $this->hasMany(Asset::class, 'product_id')->where('type', 'article');
    }
}

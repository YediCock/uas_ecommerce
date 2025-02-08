<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function scopeSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where(function($q) use ($keyword) {
                $q->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('url', 'LIKE', '%' . $keyword . '%');
            });
        } else {
            // Jika tidak ada pencarian, tampilkan semua data termasuk yang null
            return $query;
        }
    }
}

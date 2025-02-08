<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('status', 'LIKE', '%' . $keyword . '%');
        });
    }
}

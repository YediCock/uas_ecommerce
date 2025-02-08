<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function takeAttributes()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function getAttributeValues()
{
    return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    public $timestamps = false;

    public function productType() 
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function hotel() 
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'nama_fasilitas',
        'deskripsi_fasilitas',
        'product_type_id',
        'hotel_id'
    ];
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}

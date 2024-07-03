<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotels';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'type_id',
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'hotel_id');
    }
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}

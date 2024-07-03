<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;
    protected $table = 'reservasis';
    public $timestamps = false;

    protected $fillable = [
        'tanggal_jam',
        'keterangan',
        'product_id',
        'transaction_id',
        'user_id'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

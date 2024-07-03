<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    public $timestamps = false;

    protected $fillable = [
        'price',
        'invoice',
        'total_price'
    ];
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'transaction_id');
    }
}

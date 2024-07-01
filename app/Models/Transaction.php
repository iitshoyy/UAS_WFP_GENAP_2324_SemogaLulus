<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    public $timestamps = false;

    public function reservasis() 
    {
        return $this->hasMany(Reservasis::class, 'reservasi_id');
    }
}

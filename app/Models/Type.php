<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $table = 'type';
    public $timestamps = false;

    public function hotel() 
    {
        return $this->hasMany(Hotel::class, 'hotel_id');
    }
}

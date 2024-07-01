<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotel';
    public $timestamps = false;

    public function type() 
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
}

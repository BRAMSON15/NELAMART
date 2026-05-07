<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rajaongkir extends Model
{
    protected $table = 'rajaongkir';
    protected $fillable = [
        'origin',
        'destination',
        'weight',
        'courier',
    ];
}

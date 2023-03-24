<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informem extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'fecha',
        'prod_bruta',
        'oilH',
        'oilD',
        'gas',
        'agua',
        'ventas_oil',
        'gasolina',
        'estado',

    ];

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];
}

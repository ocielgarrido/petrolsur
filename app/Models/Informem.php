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
        'oilB',
        'oilH',
        'oilD',
        'pm10',
        'pm316',
        'a9300',
        'cgas', //consumo gas= pm10-pm316
        'tgas', // total gas= consumo+pm316
        'agua',
        'ventas_oil',
        'gasolina',
        'fileCapIV',
        'estado',

    ];

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];
}

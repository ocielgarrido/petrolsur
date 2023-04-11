<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculor extends Model
{
    use HasFactory;
    protected $fillable = [
        //Campos para calculos
        'yacimiento_id',
        'well_id', 
        'bcr', //bruta controles cb
        'ncr', //neta controles  cd
        'acr',   // agua controles ce 
        'porce',  // % ajuste b35
        'ajuste',  // ajuste es lo real que se informa b36
        'tcb',
        'tcc',
        'tcd',
        'tcd',

    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculo extends Model
{
    use HasFactory;
    protected $fillable = [
        //Campos para gas
        'yacimiento_id',
        'well_id', 
        'pozo',
        'fecha',
        'm3gas_control' ,
        'porce_prod',
        'mt3gas_declara',
        'agua_declara',
        'total_mes' ,
        'total_gral',
        // campos para petroleo
        //'bruta_m3',
       // 'agua',
       // 'neta_m3',
       // 'agua_m3',
       // 'porce_total',
       // 'bruta_declara',
      //  'neta_declara',
        
    ];
}

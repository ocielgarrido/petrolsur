<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'yacimiento_id',
        'well_id',
        'periodo',
        'secuencia', //0 original, 1 Rectificativa 1 y asi
        'prod_oilH',
        'prod_oilD',
        'prod_gas',
        'prod_agua',
        'prod_acum_oilH',
        'prod_acum_oilD',
        'prod_acum_gas',
        'prod_acum_agua',
        'iny_agua',
        'iny_gas',
        'iny_co',
        'iny_otros',
        'rgp',
        'porce_agua',
        'tef',
        'vida_util',
        'sis_extrac',
        'estado_well',
        'tipo_well',
        'obs',
        'vida_util',
        'estado',

    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Djj extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'well_id',
        'pozo', //nombre pozo para petrolsur
        'idpozo', // primer campo
        'prod_pet', //sendo campo
        'prod_gas',
        'prod_agua',
        'iny_agua',
        'iny_co',
        'iny_otro',
        'tef' ,//dias
        'v_util', //vida util
        'well_state_id', //PE=produccion efectiva, PT=parado transitorio, PE=parado en estudio (ARAP Cap IV)
        'pet', //Tipo pozo GAS PET 
        'pist',  //tipo extraccion
        'obs' 

 


    ];
}

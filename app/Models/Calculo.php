<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculo extends Model
{
    use HasFactory;
    protected $fillable = [
        //Campos para calculos
        'yacimiento_id',
        'well_id', 
        'pozo',
        'dia',
        'fecha',
        'cb',
        'cc',
        'cd',
        'ce',
        'cf',
        'cg',
        'ch',
        'ci',
        'cj',
        'oilB',
        'oilD',
        'aguaM3',
        'aguaP',
        'dias',
        'v_util',
        'pet', 
        'totalM' ,
        'totalG',       
        
    ];

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
        'dia' => 'datetime:d-m-Y',
    ];

    public function welll(){
        return $this->hasOne("App\Models\well");
    }
    public function well_state() {
        return $this->belongsTo(WellState::class);
    }

}

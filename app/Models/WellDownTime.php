<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WellDownTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'well_id',
        'fecha',
        'horas', //id tanque
        'well_cause_id',
        'agua_perdido_mt3',
        'oil_perdido_mt3',
        'gas_perdido_mt3',
        'obs',
        'estado'

    ];
    public static function search($query)
    {
        return empty($query) ? static::query()
        : static::join('wells', 'wells.id', '=', 'well_down_times.well_id')
            ->select('well_down_times.*','wells.pozo')
            ->where('fecha', 'like', '%'.$query.'%')
            ->orWhere('pozo', 'like', '%'.$query.'%')                
            ->orWhere('obs', 'like', '%'.$query.'%');                
                  
    }
    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];

  
    public function well(){
        return $this->belongsTo(Well::class);
    }

    public function wellcause(){
        return $this->belongsTo(WellCause::class, 'well_cause_id', 'id');    
    }
  

}

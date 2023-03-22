<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WellIntervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',    
        'well_id',    
        'fecha',
        'motivo',
        'obs',
        'estado'
    ];

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];

    
  
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::join('wells', 'wells.id', '=', 'well_interventions.well_id')
            ->select('well_interventions.*','wells.pozo')
            ->Where('fecha', 'like', '%'.$query.'%')              
            ->orWhere('motivo', 'like', '%'.$query.'%')              
            ->orWhere('pozo', 'like', '%'.$query.'%')               
            ->orWhere('obs', 'like', '%'.$query.'%');                
                  
    }

 

    public function well(){
        return $this->belongsTo(Well::class);
    }

}

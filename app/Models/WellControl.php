<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WellControl extends Model
{
    use HasFactory;

    protected $fillable = [
    'area_id',    
    'well_id',    
    'fecha',
    'horas',
    'agua_emul_por',
    'prod_bruta_mt3',
    'oil_neto_mt3',
    'agua_neto_mt3',
    'gas_neto_mt3',
    'prod_bruta_24',
    'oil_neto_24',
    'agua_neto_24',
    'gas_neto_24',
    'carrera',
    'gpm',
    'orificio',
    'gas_producido_mt3',
    'estado'
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::join('wells', 'wells.id', '=', 'well_controls.well_id')
                ->select('well_controls.*','wells.pozo')
                ->where('fecha', 'like', '%'.$query.'%')
                ->orWhere('horas', 'like', '%'.$query.'%')              
                ->orWhere('carrera', 'like', '%'.$query.'%')              
                ->orWhere('gpm', 'like', '%'.$query.'%')               
                ->orWhere('orificio', 'like', '%'.$query.'%')               
                ->orWhere('pozo', 'like', '%'.$query.'%');                
                  
    }
  
    
    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];

    public function well(){
        return $this->belongsTo(Well::class);
    }
  

   

  }

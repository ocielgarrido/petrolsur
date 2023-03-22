<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TankControl extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',    
        'tank_id',    
        'fecha',
        'agua',
        'sales',
        'temp',
        'densidad',
        'estado',

    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::join('tanks', 'tanks.id', '=', 'well_controls.tank_id')
                ->select('tank_controls.*','tank.nombre')
                ->where('fecha', 'like', '%'.$query.'%')
                ->orWhere('nombre', 'like', '%'.$query.'%');                
                  
    }
  
    
    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];

    public function Tank(){
        return $this->belongsTo(Tank::class);
    }

}

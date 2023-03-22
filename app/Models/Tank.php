<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'codigo',
        'nombre',
        'capacidad',
        'cte',
        'api',
        'fabricacion',      
        'interno', //si o no
        'alturaT',
        'altura', //altura total         
        'largo', //altura total         
        'obs',
        'estado',
    
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('codigo', 'like', '%'.$query.'%')
                ->orWhere('nombre', 'like', '%'.$query.'%');
    }


    public function tanks() {
        return $this->belongsTo(Tank::class);
    }
  
  
}

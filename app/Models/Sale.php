<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'fecha',
        'remito',
        'tank_id', //id tanque
        'product_id',
        'total', //volumen mt3 ventido
        'estado',
        'obs'

    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::join('tanks', 'tanks.id', '=', 'sales.tank_id')
                ->select('sales.*','tanks.nombre')
                ->where('fecha', 'like', '%'.$query.'%')
                ->orWhere('remito', 'like', '%'.$query.'%')                
                ->orWhere('nombre', 'like', '%'.$query.'%')                
                ->orWhere('remito', 'like', '%'.$query.'%');                
                  
    }

  


    public function tank(){
        return $this->belongsTo(Tank::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];
}

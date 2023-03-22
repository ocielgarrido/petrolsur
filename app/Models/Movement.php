<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'client_id',
        'product_id',
        'fecha',
        'tipo',
        'remito',
        'torigen',
        'tdestino',
        'tank_id_ori',
        'well_id_ori',
        'tank_id_des',
        'well_id_des',
        'volumen',
        'estado',
        'obs',
        
        
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('id', 'like', '%'.$query.'%')
                ->orWhere('fecha', 'like', '%'.$query.'%')
                ->orWhere('tipo', 'like', '%'.$query.'%')
                ->orWhere('volumen', 'like', '%'.$query.'%');   
                
    }

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];

    public function tank(){
        return $this->belongsTo(Tank::class);
    }

    public function well(){
        return $this->belongsTo(Well::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function cliente(){
        return $this->belongsTo(Client::class);
    }


}

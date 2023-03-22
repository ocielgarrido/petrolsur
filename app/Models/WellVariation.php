<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WellVariation extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'fecha',
        'mt3',
        'obs',
        'estado',

    ];

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];

    public static function search($query)    {
       
        return empty($query) ? static::query()
            : static::where('fecha', 'like', '%'.$query.'%')
                 ->orWhere('id', 'like', '%'.$query.'%')                
                 ->orWhere('mt3', 'like', '%'.$query.'%')                
                 ->orWhere('obs', 'like', '%'.$query.'%')          
                 ->orWhere('estado', 'like', '%'.$query.'%');                
                  
    }
}

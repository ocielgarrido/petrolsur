<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasseConsumo extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'fecha',
        'consumo',
        'estado',

    ];
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('id', 'like', '%'.$query.'%')
                ->orWhere('fecha', 'like', '%'.$query.'%')
                ->orWhere('consumo', 'like', '%'.$query.'%');
                
    }
    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];
}

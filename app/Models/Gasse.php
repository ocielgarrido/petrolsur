<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasse extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'client_id',
        'fecha',
        'pm10',
        'pm316',
        'a9300',
        'pm316_c',
        'a9300_c',
        'estado',

    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('id', 'like', '%'.$query.'%')
                ->orWhere('fecha', 'like', '%'.$query.'%')
                ->orWhere('pm10', 'like', '%'.$query.'%')
                ->orWhere('pm316', 'like', '%'.$query.'%')
                ->orWhere('a9300', 'like', '%'.$query.'%');
                
    }
    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oil extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'fecha',
        'oil',  //oil mts
        'agua', //agua en mt3
        'total', //suma agua + oil
        'venta', //sumatoria ventas del dia
        'oil_production',
        'estado',
        'obs'

    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('id', 'like', '%'.$query.'%')
                ->orWhere('fecha', 'like', '%'.$query.'%')
                ->orWhere('obs', 'like', '%'.$query.'%');

    }

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];

    public function OilDetails(){
        return $this->hasMany("App\Models\OilDetail");
    }
}

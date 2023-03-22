<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OilDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'oil_id', //id produccion
        'tank_id', //id tanque
        'altura',  // altura total en cms
        'corte_agua', //corte Agua cms
        'oil', //stock petroleo del tanque (altura-corte_agua) * cte en mt3
        'agua', // stok agua del tanque  (corte_agua * cte) en mt3
        'total', // oil+ agua en mt3
 
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('id', 'like', '%'.$query.'%')
                ->orWhere('oil_id', 'like', '%'.$query.'%');
               

    }

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];
    public function Oil(){
        return $this->belongsTo("App\Models\Oil");
    }
    public function tank(){
        return $this->belongsTo(Tank::class);
    }
}

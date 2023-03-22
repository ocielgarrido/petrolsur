<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompressorDownTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'compressor_id',
        'fecha',
        'CompressorCause_id',
        'horas',
        'horas_paro_msa',
        'horas_standby',
        'obs',

    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('fecha', 'like', '%'.$query.'%')
                 ->orWhere('hora', 'like', '%'.$query.'%')                
                 ->orWhere('id', 'like', '%'.$query.'%')                
                ->orWhere('obs', 'like', '%'.$query.'%');                
                  
    }

    public function compressor(){
        return $this->belongsTo(Compressor::class);
    }
    public function compressorcause(){
        return $this->belongsTo(CompressorCause::class);
    }
  
    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];
}

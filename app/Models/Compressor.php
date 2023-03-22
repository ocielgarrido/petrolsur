<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compressor extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'nombre',
        'estado',

    ];

    public function CompressorDownTime(){
        return $this->hasMany("App\Models\CompressorDownTime");
    }

 

}

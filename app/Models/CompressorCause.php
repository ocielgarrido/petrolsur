<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompressorCause extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'causa',
   
    ];

    public function CompressorDownTime(){
        return $this->hasMany("App\Models\CompressorDownTime");
    }

}

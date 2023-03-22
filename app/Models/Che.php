<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Che extends Model
{
    use HasFactory;
    protected $fillable = [
        'provider_id',
        'area_id',
        'fecha',
        'hora',
        
     ];
}

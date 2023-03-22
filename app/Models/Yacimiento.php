<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yacimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'nombre',
        'obs'

    ];
}

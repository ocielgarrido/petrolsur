<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheProp extends Model
{
    use HasFactory;
    protected $fillable = [
        'ch_id',
        'pm',
        'vm',
        'dabs',
        'drelat',
        'pcsm3',
        'pcskg',
        'pcim3',
        'iwobbe',
        'cp',
        'cv',
        'k',
        'compz',
        'presion',
        'temp', 
    ];
}

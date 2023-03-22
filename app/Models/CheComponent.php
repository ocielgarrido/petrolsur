<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheComponent extends Model
{
    use HasFactory;
    protected $fillable = [
        'ch_id',
        'n2',
        'co2',
        'ch4',
        'c2h6',
        'c3h8',
        'ic4h10',
        'nc4h10',
        'ic5h12',
        'nc5h12',
        'c6h14',
        'c7h16',
        'c8h18',
        'o2',
        
 
    ];
}

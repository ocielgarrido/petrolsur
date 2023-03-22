<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'obs',
 
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('fecha', 'like', '%'.$query.'%')
                 ->orWhere('obs', 'like', '%'.$query.'%');                
                  
    }

    protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ];
}

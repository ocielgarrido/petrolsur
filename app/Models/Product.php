<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'production', 
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('nombre', 'like', '%'.$query.'%')
                 ->orWhere('id', 'like', '%'.$query.'%');                
                  
    }
 
   
 
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'cuit',
        'email',
        'direccion',
        'telefono',
        'estado',

    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('nombre', 'like', '%'.$query.'%')
                ->orWhere('cuit', 'like', '%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%')
                ->orWhere('id', 'like', '%'.$query.'%')                
                ->orWhere('telefono', 'like', '%'.$query.'%');   
                
    }
}

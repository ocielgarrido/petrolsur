<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider;
use Illuminate\Support\Facades\Gate;

class ProviderController extends Controller
{
    public function index()
    {
        
        abort_if(Gate::denies('Proveedores'), 403); 
        return view('pages.provider.provider-data', [
            'provider' => Provider::class
        ]);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oil;
use App\Models\Gasse;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $graficoOilAnio = Oil::select(\DB::raw("sum(*) as mes"))
                    ->whereYear('fecha', date('Y'))
                    ->groupBy(\DB::raw("Month(fecha)"))
                    ->pluck('count');
          
        return view('dashboard', compact('graficoOilAnio'));
    }

 
}

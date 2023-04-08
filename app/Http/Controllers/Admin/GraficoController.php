<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Informem;

class GraficoController extends Controller
{
    
    public function prod_oil_mensual(Request $request){
        $data= Informem::select(
          DB::raw('sum(oilD) as oil'),
          DB::raw("DATE_FORMAT(fecha,'%m-%Y') as meses"),
       )
          ->groupBy('meses')
          ->orderBy('fecha','asc')
          ->get();  
        
       if($request->ajax()){                        
          return response(json_encode($data),200)->header('Content-type','text/plain');  
       }
    }

    public function prod_gas_mensual(Request $request){
        $data= Informem::select(
          DB::raw('sum(gas) as gas'),
          DB::raw("DATE_FORMAT(fecha,'%m-%Y') as meses"),
       )
          ->groupBy('meses')
          ->orderBy('fecha','asc')
          ->get();  
        
       if($request->ajax()){                        
          return response(json_encode($data),200)->header('Content-type','text/plain');  
       }
    }

}

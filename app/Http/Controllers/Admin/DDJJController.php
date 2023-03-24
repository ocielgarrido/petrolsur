<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DDJJController extends Controller
{
     
    public function calcularGas(){
        return view('pages.ddjj.capiv');
    }

    public function descarga($folder, $filename){
        $pathtoFile = storage_path().'//ddjj/' .$folder .'/'.$filename;            
        return response()->download($pathtoFile);
       
     }

}

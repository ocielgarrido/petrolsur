<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DDJJController extends Controller
{
     
    public function ddjj(){
        abort_if(Gate::denies('Generar_DDJJ'), 403); 
        return view('pages.ddjj.capiv');
    }

    public function descarga($folder, $filename){
        abort_if(Gate::denies('Generar_DDJJ'), 403); 
        $pathtoFile = storage_path().'//ddjj/' .$folder .'/'.$filename;            
        return response()->download($pathtoFile);
       
     }

}

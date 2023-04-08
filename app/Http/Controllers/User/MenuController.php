<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Area;
use App\Models\Client;
use App\Models\Product;
use App\Models\Provider;
use App\Models\CompressorDownTime;
use App\Models\Compressor;
use App\Models\Well;
use App\Models\WellControl;
use App\Models\WellDownTime;
use App\Models\Tank;
use App\Models\TankControl;
use App\Models\Sale;
use App\Models\Movement;
use App\Models\WellIntervention;
use App\Models\WellVariation;
use App\Models\Post;
use App\Models\Gasse;
use App\Models\GasseConsumo;
use App\Models\Oil;

//para excel y demas
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Facades\FromQuery;
use Maatwebsite\Excel\Facades\Exportable;
use App\Exports\WellControlExport;

class MenuController extends Controller
{
    //Tablas de Sistema //
    public function area()
    {        
        abort_if(Gate::denies('Areas'), 403);
        return view('pages.area.area-data', [
            'area' => Area::class
        ]);
    }
    public function pozo(){
        abort_if(Gate::denies('Pozos'), 403); 
        return view('pages.well.well.data', [
            'well' => Well::class
        ]);
    }

    public function tanque(){
        abort_if(Gate::denies('Tanques'), 403); 
        return view('pages.tank.tank-data', [
            'tank' => Tank::class
        ]);
    }

    public function cliente()
    {        
        abort_if(Gate::denies('Clientes'), 403);
        return view('pages.client.client-data', [
            'client' => Client::class
        ]);
    }
    public function proveedor()
    {        
        abort_if(Gate::denies('Proveedores'), 403); 
        return view('pages.provider.provider-data', [
            'provider' => Provider::class
        ]);
    }
    public function producto(){
        abort_if(Gate::denies('Producto'), 403); 
        return view('pages.product.product-data', [
            'product' => Product::class
        ]);
    }
  
 



    //Carga de Datos //

    public function controltanque(){     
      //  abort_if(Gate::denies('TankControl'), 403); 
        return view('pages.tank.control.control-data', [
            'tankcontrol' => TankControl::class
        ]);
    }
    public function controlpozo(){
      //  abort_if(Gate::denies('WellControl'), 403); 
        return view('pages.well.control.control-data', [
            'wellcontrol' => WellControl::class
        ]);
    }
    public function controlpozo_excel(){
       // abort_if(Gate::denies('WellControl'), 403); 
        return Excel::download(new WellControlExport, 'controles.xlsx');
    }

    public function paradapozo(){
       // abort_if(Gate::denies('WellDownTime'), 403); 
        return view('pages.well.downtime.downtime-data', [
            'welldowntime' => WellDownTime::class,
            'well' => Well::class,
            
        ]);
    }
    public function paradamotocompresor(){
       // abort_if(Gate::denies('CompressorDownTime'), 403); 
        return view('pages.compressor.downtime.downtime-data', [
            'compressordowntime' => CompressorDownTime::class,
            'compressor' => Compressor::class,
            
        ]);
    }
    public function venta(){
        abort_if(Gate::denies('Ventas'), 403); 
        return view('pages.sale.sale-data', [
            'sale' => Sale::class
        ]);
    }
    public function movimiento(){
      //  abort_if(Gate::denies('Movimientos'), 403); 
        return view('pages.movement.movement-data', [
            'movement' => Movement::class
        ]);
    }
    public function intervencionpozo(){
     //   abort_if(Gate::denies('WellIntervention'), 403); 
        return view('pages.well.intervention.intervention-data', [
            'wellintervention' => WellIntervention::class
        ]);
    }
    public function novedad(){
      //  abort_if(Gate::denies('Novedades'), 403); 
        return view('pages.post.post-data', [
            'post' => Post::class
        ]);
    }
    public function incrementomerma(){
      //  abort_if(Gate::denies('WellVariation'), 403); 
        return view('pages.well.variation.variation-data', [
            'wellvariation' => WellVariation::class
        ]);
    }

    public function gas(){
     //   abort_if(Gate::denies('Gas'), 403); 
        return view('pages.gasse.gasse-data', [
            'gasse' => Gasse::class
        ]);
    }
    public function gasConsumo(){
        //   abort_if(Gate::denies('Gas'), 403); 
           return view('pages.gasse.consumo.consumo-data', [
               'consumos' => GasseConsumo::class
           ]);
       }
   
    public function mediciontanque(){
     //   abort_if(Gate::denies('Oil'), 403); 
        return view('pages.oil.oil-data', [
            'oil' => Oil::class
        ]);
    }
}

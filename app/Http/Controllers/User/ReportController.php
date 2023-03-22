<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Gate;

use App\Models\Post; 
use App\Models\Oil;
use App\Models\OilDetail;
use App\Models\Gasse; 
use App\Models\Sale; 
use App\Models\Movement; 
use App\Models\WellIntervention;
use App\Models\CompressorDownTime;
use App\Models\WellControl;
use App\Models\WellDownTime;
use App\Models\WellVariation;
use App\Models\HTablet;
//use App\Models\Tanks; 
use App\Models\Well; 
//use Carbon\Carbon;
//use Barryvdh\DomPDF\PDF as DOMPDF;
use DateTime;


class ReportController extends Controller
{
    public function index()
    {
        
        abort_if(Gate::denies('Reportes'), 403); 
        return view('pages.report.report.index', [
            'report' => Report::class
        ]);
    }


    public function ReportPDF($reportId,$fechaTo=null,$fechaFrom=null, $well_id=null){
     
        switch($reportId) {
            case('1'):
                $fecha= (new DateTime($fechaTo))->format('Y-m-d');
                $fecha_anterior= (new DateTime($fecha))->modify('-1 day')->format('Y-m-d');              
   
               $oil_ant= Oil::where(['fecha' =>$fecha_anterior, 'area_id'=>1])->first(); 
               $oil_dia= Oil::where(['fecha' =>$fecha, 'area_id'=>1])->first(); 
               $prod_bruta_ant=$oil_ant->prod_bruta;
               $prod_bruta_dia=$oil_dia->prod_bruta; 
               $prod_neta_ant=$oil_ant->prod_oil_d;
               $prod_neta_dia=$oil_dia->prod_oil_d; 

               $total_oil_des_ant=$oil_ant->oil_des; 
               $total_oil_des_dia= OilDetail::where('oil_id', $oil_dia->id)->get()->sum('oil_des'); 
               $total_oil_des_ant=$oil_ant->oil_des; 
               $total_oil_des_dia= OilDetail::where('oil_id', $oil_dia->id)->get()->sum('oil_des');
               $total_oil_ant=$oil_ant->oil;
               $total_oil_dia= OilDetail::where('oil_id', $oil_dia->id)->get()->sum('oil');
               $total_agua_ant=$oil_ant->agua;
               $totat_agua_dia= OilDetail::where('oil_id', $oil_dia->id)->get()->sum('agua');
               $total_volumen=  OilDetail::where('oil_id', $oil_dia->id)->get()->sum('total');       
               $ventas= Sale::select('total')->where([ 'fecha' => $oil_dia->fecha,'area_id' =>1])->get()->sum('total');
               $ventas = $ventas ??  0;       
               $movint_agua= Movement::select('volumen')->where(['fecha' => $oil_dia->fecha,'tipo'=>'mov_int', 'torigen'=>'T' ,'tdestino'=>'W', 'area_id' =>1, 'product_id' =>4])->get()->sum('volumen');
               $movint_agua = $movint_agua ??  0;       
               $movint_oil= Movement::select('volumen')->where(['fecha' => $oil_dia->fecha,'tipo'=>'mov_int','torigen'=>'T' ,'tdestino'=>'W', 'area_id' =>1, 'product_id' =>2])->get()->sum('volumen');
               $movint_oil = $movint_oil ??  0;       
               $movint_gaso= Movement::select('volumen')->where(['fecha' => $oil_dia->fecha,'tipo'=>'mov_int', 'torigen'=>'T' ,'tdestino'=>'W', 'area_id' =>1, 'product_id' =>3])->get()->sum('volumen');
               $movint_gaso = $movint_gaso ??  0;       
               $movext_agua= Movement::select('volumen')->where(['fecha' => $oil_dia->fecha, 'tipo'=>'mov_ext','tdestino'=>'T', 'area_id' =>1,'product_id' =>4])->get()->sum('volumen');
               $movext_agua = $movext_agua ??  0;       
               $movext_oil= Movement::select('volumen')->where(['fecha' => $oil_dia->fecha,'tipo'=>'mov_ext','tdestino'=>'T', 'area_id' =>1,'product_id' =>2])->get()->sum('volumen');
               $movext_oil = $movext_oil ??  0;              
               $movext_gaso= Movement::select('volumen')->where(['fecha' => $oil_dia->fecha,'tipo'=>'mov_ext', 'tdestino'=>'T', 'area_id' =>1,'product_id' =>3])->get()->sum('volumen');
               $movext_gaso = $movext_gaso ??  0;
               $movext= Movement::select('volumen')->where(['fecha' => $oil_dia->fecha,'tipo'=>'mov_ext', 'area_id' =>1])->get()->sum('volumen');
               $movext = $movext ??  0;
               $movint= Movement::select('volumen')->where(['fecha' => $oil_dia->fecha,'tipo'=>'mov_int', 'area_id' =>1])->get()->sum('volumen');
               $movint = $movint ??  0;         
               $prod_gas= Gasse::select('a9300')->where([ 'fecha' =>$fecha, 'area_id' =>1])->get()->sum('a9300');  
               $prod_gas = $prod_gas ??  0;
               
   
                $datosprod=array(
                    'oil_dia'=>round(($total_oil_dia),2),
                    'oil_ant'=>round(($total_oil_ant),2),

                    'oil_des_dia'=>round(($total_oil_des_dia),2),
                    'oil_des_ant'=>round(($total_oil_des_ant),2),

                    'agua_dia'=>round(($totat_agua_dia),2),
                    'agua_ant'=>round(($total_agua_ant),2),
                    'total_volumen_dia'=>round(($total_volumen),2),

                    'gas_dia' =>$prod_gas,
                    'ventas_dia'=>round($ventas,2) ,

                    'movint_agua'=>round($movint_agua,2),
                    'movint_oil'=>round($movint_oil,2),
                    'movint_gaso'=>round($movint_gaso,2),

                    'movext_agua'=>round($movext_agua,2),
                    'movext_oil'=>round($movext_oil,2),
                    'movext_gaso'=>round($movext_gaso,2),

                    'movint' => round($movint,2),                  
                    'movext' => round($movext,2),
                    'prod_bruta_dia'=>round($prod_bruta_dia,2),
                    'prod_bruta_ant'=>round($prod_bruta_ant,2),

                    'prod_neta_dia'=>round($prod_neta_dia,2),
                    'prod_neta_ant'=>round($prod_neta_ant,2),
                    

                );  

                
                $title="Reporte Producción";
                $area="CCO-NORTE";
                
                $dataWellVariations = WellVariation::select('*')->where([ 'fecha' =>$fecha])->get(); 
                $dataWellDownTimes = WellDownTime::select('*')->where([ 'fecha' =>$fecha])->get(); 
                $dataWellControls = WellControl::select('*')->where([ 'fecha' =>$fecha])->get(); 
                $dataWellInterventions = WellIntervention::select('*')->where([ 'fecha' =>$fecha])->get();
                $dataCompressorDownTimes = CompressorDownTime::select('*')->where([ 'fecha' =>$fecha])->get();               
                $dataNovedades = Post::select('*')->where([ 'fecha' =>$fecha])->get(); 
                //ahora actualizo los estados
                WellVariation::query()->where('fecha', $fecha)->update(["estado" => 'Cerrado']);
                WellDownTime::query()->where('fecha', $fecha)->update(["estado" => 'Cerrado']);
                WellControl::query()->where('fecha', $fecha)->update(["estado" => 'Cerrado']);
                WellIntervention::query()->where('fecha', $fecha)->update(["estado" => 'Cerrado']);
                CompressorDownTime::query()->where('fecha', $fecha)->update(["estado" => 'Cerrado']);
                Post::query()->where('fecha', $fecha)->update(["estado" => 'Cerrado']);
                Oil::query()->where('fecha', $fecha)->update(["estado" => 'Cerrado']);
                Gasse::query()->where('fecha', $fecha)->update(["estado" => 'Cerrado']);
               // termino actualizar 
               
                $fecha= (new DateTime($fechaTo))->format('d-m-Y');
                $pdf = app('dompdf.wrapper');
                $pdf->loadView('pages.report.html.parte', compact('datosprod','dataWellVariations',
                'dataWellDownTimes','dataWellControls','dataWellInterventions',
                'dataCompressorDownTimes','dataNovedades','title','area','fecha'));
                return $pdf->stream('Parte_Produccion.pdf');               
                break;

             case('2'):
               
                $fechaDesde= (new DateTime($fechaFrom))->format('Y-m-d');
                $fecha_anterior= (new DateTime($fechaDesde))->modify('-1 day')->format('Y-m-d');              
  
                $fechaHasta= (new DateTime($fechaTo))->format('Y-m-d');
                $fecha_anterior= (new DateTime($fechaDesde))->modify('-1 day')->format('Y-m-d'); 
                $area="CCO-NORTE";                 
                $dias = date_diff(date_create($fechaTo),date_create($fechaFrom),true);
                $dias=$dias->format("%a")+1;

                $oil_ini= Oil::where(['fecha' =>$fecha_anterior, 'area_id'=>1])->first();                 
                $oil_fin= Oil::where(['fecha' =>$fechaHasta, 'area_id'=>1])->first(); 

         
                $dataPB = Oil::select('prod_bruta')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('prod_bruta');
                $dataOILH = Oil::select('prod_oil_h')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('prod_oil_h');
                $dataOILD = Oil::select('prod_oil_d')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('prod_oil_d');
                $dataAGUA = Oil::select('prod_agua')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('prod_agua');
                $dataGAS = Gasse::select('a9300')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('a9300');
                $dataSALE = Sale::select('total')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('total');
                $dataGASO = Movement::select('volumen')->whereBetween('fecha', [$fechaDesde, $fechaHasta], )->where(['tipo'=>'mov_ext', 'tdestino'=>'T', 'area_id' =>1,'product_id' =>3])->get()->sum('volumen');
                $datosprod=array(
                    'prod_bruta'=>round($dataPB,2),
                    'prod_brutaDia'=>round($dataPB/$dias,2),
                    'prod_oil'=>round(($dataOILH),2),
                    'prod_oilDia'=>round($dataOILH/$dias,2),
                    'prod_oilD'=>round(($dataOILD),2),
                    'prod_oilDDia'=>round($dataOILD/$dias,2),
                    'prod_agua'=>round(($dataAGUA),2),
                    'prod_aguaDia'=>round(($dataAGUA)/$dias,2),
                    'prod_gas'=>round($dataGAS,2),
                    'prod_gasDia'=>round($dataGAS/$dias,0),
                    'ventas'=>round($dataSALE,2),
                    'gasolina'=>round($dataGASO,2),
                    'dias' => $dias,
                    'area' => "CCO-NORTE",
                    'desde' => $fechaFrom,
                    'hasta' =>$fechaTo
                    
                );
               
                $pdf = app('dompdf.wrapper');
                $pdf->loadView('pages.report.html.partemensual', compact('datosprod'));
                return $pdf->stream('Parte_Produccion_Mensual.pdf'); 
                break;
             case('3'):
                $title="Controles de Pozo";
                $desde= (new DateTime($fechaFrom))->format('Y-m-d');
                $hasta= (new DateTime($fechaTo))->format('Y-m-d');
                $area="CCO-NORTE";
            
                if ( $well_id=='0'){                    
                    $dataWells =WellControl::select('*')->whereBetween('fecha' ,[$desde, $hasta] )->get(); 
                    $pozo="Todos";
                } else {
                   $dataWells =WellControl::select('*')->where('well_id', $well_id)->whereBetween('fecha' ,[$desde, $hasta] )->get();                              
                   $pozo=Well::select('pozo')->where('id', $well_id)->first();
                   $pozo=$pozo->pozo;
                }                  
                $desde= (new DateTime($fechaFrom))->format('d-m-Y');
                $hasta= (new DateTime($fechaTo))->format('d-m-Y');
                $pdf = app('dompdf.wrapper');
                $pdf->loadView('pages.report.html.controlpozo', compact('dataWells','title','desde', 'hasta','area', 'pozo'));
                return $pdf->stream('Controles_de_pozo.pdf');
                break;

            case('4'):
                    $title="Ultimos Controles de Pozo";   
                    $area="CCO-NORTE";
                    $dataWells = WellControl::select('*')                                                                     
                    ->orderBy('fecha','desc')
                    ->get('*')
                    ->unique('well_id');
                    $collection=$dataWells;               
                    $datosprod=array(
                        'totalBruta'=> $collection->sum('prod_bruta_mt3'),
                        'totalOIL'=> $collection->sum('oil_neto_mt3'),
                        'totalGAS'=> $collection->sum('gas_inyectado'),  
                        'totalGASSM'=> $collection->sum('gas_neto_mt3'),
 
                    );                                             
                    $pozo="Todos";
                    $pdf = app('dompdf.wrapper');
                    $pdf->loadView('pages.report.html.ucontrolpozo', compact('dataWells','title','area','datosprod'));
                    return $pdf->stream('Ultimos_Controles_de_pozo.pdf');                
                break;    
                   
    
        }

    }
}

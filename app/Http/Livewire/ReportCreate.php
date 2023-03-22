<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

//Modelos que necesito para los informes 
use App\Models\Report;
use App\Models\Post;
use App\Models\Oil;
use App\Models\OilDetail;
use App\Models\Gasse;
use App\Models\Sale;
use App\Models\Tanks;
use App\Models\Well;
use App\Models\WellControl;
use App\Models\WellDownTime;
use App\Models\WellVariation;
use App\Models\WellIntervention;
use App\Models\CompressorDownTime;
use App\Models\Movement;
use DateTime;


class ReportCreate extends Component
{
    protected $listeners = ['confirmarParte'];

    public $report, $reports;
    public $area_id="CCO-NORTE";
    public $reportId;
    public $fechaTo, $fechaFrom, $well_id;
    public $reportPreview;
    public $datosprod=[0,0,0,0]; //  para tabla produccion
    public $dataWellVariation,$dataWellDownTime,$dataWellControl,$dataWellIntervention,
    $dataCompressorDownTime,$dataNovedades, $dataWells;
    public $wells;

    public function render(){
        $this->reports=Report::all();
        $this->wells= Well::select('*')->where( ['well_state_id' => 8, 'area_id' => 1])->get();
        $dataWellVariations='';
        $dataWellDownTime='';
        $dataWellControl='';
        $dataWellIntervention='';
        $dataCompressorDownTime='';
        $dataNovedades='';
        $dataWells='';
        if ($this->datosprod==0 && $this->reportId==1){
            return view('livewire.report-create',[
                'datos' =>0,
                'reports' => $this->reports,
                'datosprod' => $this->datosprod,
                'dataWellVariations' => $this->dataWellVariation,
                'dataWellDownTimes' => $this->dataWellDownTime,
                'dataWellControls' => $this->dataWellControl,
                'dataWellInterventions' => $this->dataWellIntervention,
                'dataCompressorDownTimes' => $this->dataCompressorDownTime,
                'dataNovedades' => $this->dataNovedades,
                'wells'=>$this->wells,           
                'dataWells'=>$this->dataWells, 
                ]);
            
        }else{
            return view('livewire.report-create',[
                'reports' => $this->reports,
                'datosprod' => $this->datosprod,
                'dataWellVariations' => $this->dataWellVariation,
                'dataWellDownTimes' => $this->dataWellDownTime,
                'dataWellControls' => $this->dataWellControl,
                'dataWellInterventions' => $this->dataWellIntervention,
                'dataCompressorDownTimes' => $this->dataCompressorDownTime,
                'dataNovedades' => $this->dataNovedades,
                'wells'=>$this->wells,           
                'dataWells'=>$this->dataWells, 
                ]);            
        }
    }

    protected function getRules(){        
        $rules = [
            'area_id' => 'required',
            'report.reportId' => 'required',
            'report.fechaFrom' => 'nullable',
            'report.fechaTo' => 'nullable',
            'report.well_id' =>'nullable'
        ];
         
            return array_merge($rules);
    
    }

    public function mount (){   
        $this->report = new report;  
        $this->area_id="CCO-NORTE";  
        $date=date_create($this->report->fechaFrom);           
        $date=date_create($this->report->fechaTo);           
        date_add($date,date_interval_create_from_date_string("-1 days"));     
        $this->primerDia=(new DateTime($this->report->fechaFrom))->modify('first day of this month')->format('d-m-Y');;

 
     
    }

    public function ViewReport(){
        $this->validate();    
        $this->emit('saved');
        
        switch ($this->report->reportId) {
          
            case '1':
                $this->report->reportId=1;
                $this->report->area="CCO-NORTE";
                $this->fechaFrom = $this->report->fechaFrom; 
                $this->fechaTo= $this->report->fechaFrom; 
                $fecha=date_create($this->fechaTo);
                $fecha_anterior=date_add($fecha,date_interval_create_from_date_string("-1 days"));
                $fecha=date_create($this->fechaTo);

                $fecha=$fecha->format('Y-m-d');                           
                $fecha_anterior=$fecha_anterior->format('Y-m-d');
    
                $oil_ant= Oil::where(['fecha' =>$fecha_anterior, 'area_id'=>1])->first(); 
                $oil_dia= Oil::where(['fecha' =>$fecha, 'area_id'=>1])->first(); 
                
                if(!$oil_dia){                   
                    $this->datosprod=0;
 
                }else{
                    $prod_bruta_ant=$oil_ant->prod_bruta;
                    $prod_bruta_dia=$oil_dia->prod_bruta;
      
                    $prod_neta_ant=$oil_ant->prod_oil_d;
                    $prod_neta_dia=$oil_dia->prod_oil_d;
      
                    $total_oil_des_ant=$oil_ant->oil_des; 
                    $total_oil_des_dia= OilDetail::where('oil_id', $oil_dia->id)->get()->sum('oil_des');
                    
      
                    $total_oil_des_ant=$oil_ant->stock_oil_d; 
                    $total_oil_des_dia= OilDetail::where('oil_id', $oil_dia->id)->get()->sum('oil_des');
    
                    $total_oil_ant=$oil_ant->stock_oil_d;
                    $total_oil_dia= OilDetail::where('oil_id', $oil_dia->id)->get()->sum('oil');
    
                    $total_agua_ant=$oil_ant->stock_agua;
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
     
                    
                    $this->datosprod=array(
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
                  
                   $this->dataWellVariation=WellVariation::select('*')->where([ 'fecha' =>$fecha])->get(); 
                   $this->dataWellDownTime =WellDownTime::select('*')->where([ 'fecha' =>$fecha])->get(); 
                   $this->dataWellControl =WellControl::select('*')->where([ 'fecha' =>$fecha])->get(); 
                   $this->dataWellIntervention =WellIntervention::select('*')->where([ 'fecha' =>$fecha])->get();
                   $this->dataCompressorDownTime =CompressorDownTime::select('*')->where([ 'fecha' =>$fecha])->get();               
                   $this->dataNovedades=Post::select('*')->where([ 'fecha' =>$fecha])->get(); 
    
                }
 
              break;
            case '2':
                $this->report->reportId=2;
                $this->report->area="CCO-NORTE";
                $this->fechaTo = $this->report->fechaTo; 
                $this->fechaFrom = $this->report->fechaFrom; 
                $fechaDesde= (new DateTime($this->fechaFrom))->format('Y-m-d');
                $fechaHasta= (new DateTime($this->fechaTo))->format('Y-m-d');
                $dias = date_diff(date_create($this->report->fechaTo),date_create($this->fechaFrom),true);
                $dias=$dias->format("%a")+1;
                $dataPB = Oil::select('prod_bruta')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('prod_bruta');
                $dataOILH = Oil::select('prod_oil_h')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('prod_oil_h');
                $dataOILD = Oil::select('prod_oil_d')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('prod_oil_d');
                $dataAGUA = Oil::select('prod_agua')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('prod_agua');
                $dataGAS = Gasse::select('a9300')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('a9300');
                $dataSALE = Sale::select('total')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->get()->sum('total');
                $dataGASO = Movement::select('volumen')->whereBetween('fecha', [$fechaDesde, $fechaHasta], )->where(['tipo'=>'mov_ext', 'tdestino'=>'T', 'area_id' =>1,'product_id' =>3])->get()->sum('volumen');
                $this->datosprod=array(
                    'prod_bruta'=>round($dataPB,2),
                    'prod_brutaDia'=>round($dataPB/$dias,2),
                    'prod_oil'=>round($dataOILH,2),
                    'prod_oilDia'=>round($dataOILH/$dias,2),
                    'prod_oilD'=>round($dataOILD,2),
                    'prod_oilDDia'=>round($dataOILD/$dias,2),
                    'prod_agua'=>round($dataAGUA,2),
                    'prod_aguaDia'=>round($dataAGUA/$dias,2),
                    'prod_gas'=>round($dataGAS,2),
                    'prod_gasDia'=>round($dataGAS/$dias,0),
                    'ventas'=>round($dataSALE,2),
                    'gasolina'=>round($dataGASO,2),
                    'dias' => $dias,
                    'area' => "CCO-NORTE",
                    'desde' => $this->report->fechaFrom,
                    'hasta' =>$this->report->fechaTo                   
                );
                //dd($this->datosprod);
                break;
                 
            //Tabla Tanques    
            case '3':
                    $this->report->reportId=3;
                    $this->report->area="CCO-NORTE";
                    $this->fechaFrom = $this->report->fechaFrom; 
                    $this->fechaTo = $this->report->fechaTo; 
                    $this->well_id=$this->report->well_id;
                    $from= (new DateTime($this->fechaFrom))->format('Y-m-d');
                    $to= (new DateTime($this->fechaTo))->format('Y-m-d');

                    if ( $this->well_id=="0"){
                        $this->well_id="0";
                        $this->dataWells =WellControl::select('*')->whereBetween('fecha' ,[$from, $to] )->get(); 
                    } else {
                        $this->dataWells =WellControl::select('*')->where('well_id', $this->well_id)->whereBetween('fecha' ,[$from, $to] )->get(); 

                    }                  
                    break;
            case '4':
                    $this->report->reportId=4;
                    $this->report->area="CCO-NORTE";
                    $this->dataWells = WellControl::select('*')                                                                     
                    ->orderBy('fecha','desc')
                    ->get('*')
                    ->unique('well_id');
                    $collection=$this->dataWells;                    
                     $this->datosprod=array(
                         'totalBruta'=> $collection->sum('prod_bruta_mt3'),
                         'totalOIL'=> $collection->sum('oil_neto_mt3'),
                         'totalGAS'=> $collection->sum('gas_inyectado'),
                         'totalGASSM'=> $collection->sum('gas_neto_mt3'),

 
                     );                            
                break;
    
        
        }
    }

  
}

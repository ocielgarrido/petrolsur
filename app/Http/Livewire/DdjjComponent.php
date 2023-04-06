<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Well;
use App\Models\WellControl;
use App\Models\Informem;
use App\Models\Calculo;
use App\Models\Gasse;

use App\Models\WellDownTime;
use App\Models\Djj;
use Illuminate\Support\Facades\DB;
use DateTime;
use DatePeriod;
use DateInterval;

class DdjjComponent extends Component
{
    public $desde;
    public $hasta;
    public $wellId;
    public $calculo=[];

    public function calcularDdjj(){
      DB::table('calculos')->delete();
      DB::table('djjs')->delete();
     // $this->calcularGas(); 
     $this->calcularGas($this->desde,$this->hasta);
    }
    public function calcularOil(){
      $pozos =Well::select('*')->where(['tipo'=>'PET','well_state_id' =>8 ])->orderBy('id')->get();
      $primerDia=date_create($this->desde); 
      //fechas para consultas  
      $primerDia=$primerDia->format('Y-m-d');
      $ultimoDia=date("Y-m-t", strtotime($primerDia)); 
       //Fechas para mostrar
      $fechaInicio=strtotime($this->desde);      
      $fechaFin=strtotime($this->hasta);

      $totalGral=0;
      foreach($pozos as $p){     
        //recorro cada pozo gas dia a dia
        $total=0; //corresponde a celda a celda b35 lo que sumand todas las B
        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
           //86400 es el número de segundos que tiene 1 día
          $dias=($fechaFin-$fechaInicio)/86400; 
          $dias=$dias +1;
          //de aca saco valores columna  D y E de excel
          $m3Control=$this->buscaControl(date("Y-m-d", $i), $p->id); //si no encuentro control del día, me devuelve datos control proximo anterior
         
         // $total=$total+$m3Control;
          $total=$total+$m3Control->prod_bruta_mt3;           
            $result=[ 
              //Campos para gas
              'yacimiento_id' =>$p->yacimiento_id,
              'well_id' =>$p->id, 
              'pozo' =>$p->pozo, 
              'dia' =>date("d-m-Y", $i),
              'fecha' => date("Y-m-d", $i),
              'bruta_mt3' =>$m3Control->prod_bruta_mt3, //celda b1 a final mes
              'porce_agua'=>$m3Control->agua_emul_por,  //celda d1
              'mt_agua'=>$m3Control->agua_neto_24, //celda e1
              'total_mes' => $total, //celda b35
              'total_gral' => $totalGral+$totalGral+$total,
              'dias' =>$dias,
              'v_util'=> $this->buscaParada(date("Y-m-d", $i), $p->id),
              
              ];             
              $calculo[]=$result;
        }
        dd($calculo);
        $totalGral=$totalGral+$total;
        Calculo::insert($calculo);   
    }
   
    }
  
    public function calcularGas($desde, $hasta){
      //Elimino datos tablas
      //Obtengo pozos activos de gas
      $pozos =Well::select('*')->where(['tipo'=>'GAS','well_state_id' =>8 ])->orderBy('id')->get();
      $primerDia=date_create($desde); 
      //fechas para consultas  
      $primerDia=$primerDia->format('Y-m-d');
      $ultimoDia=date("Y-m-t", strtotime($primerDia)); 
       //Fechas para mostrar
      $fechaInicio=strtotime($desde);      
      $fechaFin=strtotime($hasta);
      //Aca obtengo total ventas gas a Tgs
      //Consumo Celda J44 es diferencia de ambos calculos posteriores (pm10-pm316)
      $totalpm316=Gasse::whereBetween('fecha', [$primerDia, $ultimoDia])->sum('pm316'); //Aca obtengo total ventas gas a Tgs Celda J43 vta std tgs
      $totalpm10=Gasse::whereBetween('fecha', [$primerDia, $ultimoDia])->sum('pm10'); //Aca obtengo total ventas gas a Tgs Celda J44 consumo
      $totalGas=$totalpm10+$totalpm316; //Celda J45 total    
      $consumo=$totalpm10-$totalpm316; //Celda J45 total    
     
      $totalGral=0; //total grel corresponde a valor celda D39
      
      foreach($pozos as $p){     
        //recorro cada pozo gas dia a dia
        $total=0; //corresponde a celda a celda b35 lo que sumand todas las B
          for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
             //86400 es el número de segundos que tiene 1 día
            $dias=($fechaFin-$fechaInicio)/86400; 
            $dias=$dias +1;
            //de aca saco valores columna  D y E de excel
            $m3Control=$this->buscaControl(date("Y-m-d", $i), $p->id); //si no encuentro control del día, me devuelve datos control proximo anterior
         
           // $total=$total+$m3Control;
            $total=$total+$m3Control->gas_neto_mt3;           
              $result=[ 
                //Campos para gas
                'yacimiento_id' =>$p->yacimiento_id,
                'well_id' =>$p->id, 
                'pozo' =>$p->pozo, 
                'dia' =>date("d-m-Y", $i),
                'fecha' => date("Y-m-d", $i),
                'm3gas_control' =>$m3Control->gas_neto_mt3, //celda b1 a final mes
                'porce_prod'=>0,
                'mt3gas_declara'=>0,                
                'agua_declara'=>$m3Control->agua_neto_24, //celda e1
                'total_mes' => $total, //celda b35
                'total_gral' => $totalGral+$totalGral+$total,
                'dias' =>$dias,
                'v_util'=> $this->buscaParada(date("Y-m-d", $i), $p->id),
                
                ];             
                $calculo[]=$result;
          }
          $totalGral=$totalGral+$total;
        
      }
      //Acá guardo datos
      Calculo::insert($calculo);    
      //actualizo todos los registro de tabla cacluloscampo total_gral con $totalGral
      Calculo::select('*')->update(['total_gral'=>$totalGral,]); 
            //Calculo totales para completar resto campos (me sirve en cierta forma)
            $data= Calculo::select(
              DB::raw('sum(calculos.agua_declara) as tAgua'),
              DB::raw('sum(calculos.m3gas_control) as tgas'),
              DB::raw("calculos.well_id"),
              )
               ->groupBy('calculos.well_id')
              ->orderBy('calculos.well_id')
              ->get(); 
           
            $porcePorpozo=[];  
             
      foreach($data as $d){                    
        //acá obtendo co d->tgas valor celda b35  de cada pozo        
         $porceWell=$d->tgas*100/$totalGral; //Acá obtengo porcentaje por pozo celda b36
         $pozo=$d['well_id']; //tengo id pozo
         $result=[
           'well_id' =>$pozo,
           'porce_well' => $porceWell, //celda b36
           'celdab37' =>($d->tgas*100) /$totalGas, //celda b37
           'consumo' => $totalpm10-$totalpm316,
           'vta_std' =>$totalpm316,
           'total_gas' => $totalpm316+$consumo, //celda j45
           'total35' =>  ($totalpm316+$consumo)*$porceWell/100, //sumatoria celda b35
           
          
         ];
         //acá obtengo porcentaje final de cada pozo
         $porcePorpozo[]=$result;      
         $this->finCalculosGas($totalGas,$porcePorpozo, $ultimoDia,$dias);
      }  
      //dd($porcePorpozo);  
      
    }
    //funcion que calcula porcentaje individual por dia 
    private function finCalculosGas($totalGas, $porcePorpozo, $ultimoDia, $dias){
   
      //ahora relleno resto celdas tabla
      foreach($porcePorpozo as $p){ 
        //aca empieza un pozo
        $results=Calculo::select('*')->where(['well_id' => $p['well_id']])->orderBy('fecha', 'asc')->get();
        $totalPozo=Calculo::select('*')->where(['well_id' => $p['well_id']])->where(['fecha' =>$ultimoDia])->first();
      
        foreach($results as $r){
         //acá empieza un día de un pozo
          Calculo::query()
          ->where('well_id', $p['well_id'])           
          ->update([
              "porce_prod" => floatval($r['m3gas_control']) *100/ $totalPozo->total_mes,
              "mt3gas_declara" =>(floatval($r['m3gas_control']) *100/ $totalPozo->total_mes)/100*$p['total35'],
          ]);
        }  
        
      }
      $prodGas=Calculo::where(['well_id' => $p['well_id']])->sum('mt3gas_declara');
      $prodAgua=Calculo::where(['well_id' => $p['well_id']])->sum('agua_declara');
      $vidaUtil=Calculo::where(['well_id' => $p['well_id']])->sum('v_util');
      $datosWell=Well::where(['id' => $p['well_id']])->first();

      $resultFinal=[
        'area_id' =>1,
        'well_id' =>$p['well_id'],
        'pozo' => $totalPozo->pozo, // nombre pozo
        'idpozo' => $datosWell->idpozo, //idpozo ddjj
        'prod_pet' => 0, //producciion petroleo
        'prod_gas' =>$prodGas ,// produccion gas =sumatoria campo mt3gas_declara tabla calculos por pozo
        'prod_agua' => $prodAgua,
        'iny_agua' =>0,
        'iny_co' =>0,
        'iny_otro' =>0,
        'v_util'=>$dias-$vidaUtil,
        'pist' => 'GS', //Tipo Extraxion Gas Lift por ejemplo
        'arap' =>$datosWell->well_state->codigo,
        'pet'=>$datosWell->tipo

      ];
     
      
      //Acá termina un pozo
      Djj::insert($resultFinal);
    }  

    //Función que busca el control de pozo del día, si no lo hay, busca el proximo anterior
    private function buscaControl($fecha, $idWell){
      //busco si hay un control con esa fecha y pozo
      $count =WellControl::where(['fecha'=>$fecha, 'well_id'=>$idWell])->count();     

      if ($count==1){
        $result=WellControl::where(['fecha'=>$fecha, 'well_id'=>$idWell])->first();
        return $result;
      }else{
        $result=WellControl::where('fecha','<',$fecha)->where('well_id','=', $idWell)->orderBy('fecha','desc')->first();
        return $result;
      } 
    }
    private function buscaParada($fecha, $idWell){
      //busco si hay una parada esa fecha y pozo
      $count =WellDownTime::where(['fecha'=>$fecha, 'well_id'=>$idWell])->count();
     
      if ($count==1){
        $result=1;
        return $result;  
      }else{
        return 0;
      } 
    }

    public function render()
    {
        return view('livewire.ddjj-component',[
            'wells' => Well::all(),
     
            
        ]);   
    }
}

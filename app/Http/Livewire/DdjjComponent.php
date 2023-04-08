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
    public $tipo;
    public $area_id;

    public $ddjj;    
    public $calculo=[];

    protected function getRules(){ 

      $rules = [
        'tipo' => 'required'
       ];

      return array_merge([
          'area_id' => 'required',
          'tipo' =>  'required',
          'desde' => 'required',
          'hasta' => 'required',
 
        ], $rules);

    } 
    public function mount (){
      $this->area_id=1;
    }


    public function calcularDdjj(){         
      $this->resetErrorBag();
      $this->validate();

      switch ($this->tipo) {       
        case '1':
          //Capitulo IV TXT
          DB::table('calculos')->delete();
        //  DB::table('djjs')->delete();
        //  $this->calcularGas($this->desde,$this->hasta);
         // DB::table('calculos')->delete();
          $this->calcularOil($this->desde,$this->hasta);     
          break;
        case '2':
          //Regalias
          break;
        case '3':
          //Cesco
          break;
    
      }
    }

      public function calcularGas($desde, $hasta){
        //Obtengo pozos activos de gas
        $pozos =Well::select('*')->where(['pet'=>'GAS','well_state_id' =>8 ])->orderBy('id')->get();
        //convierto fechas calendario para consultas y mostrar  
        $primerDia=date_create($desde);         
        $primerDia=$primerDia->format('Y-m-d');
        $ultimoDia=date("Y-m-t", strtotime($primerDia)); 
        //Fechas para mostrar
        $fechaInicio=strtotime($desde);      
        $fechaFin=strtotime($hasta);
        //Aca obtengo total ventas gas a Tgs
        //Consumo Celda J44 es diferencia de ambos calculos posteriores (pm10-pm316)
        $totalpm316=Gasse::whereBetween('fecha', [$primerDia, $ultimoDia])->sum('pm316'); //Aca obtengo total ventas gas a Tgs Celda J43 vta std tgs
        $totalpm10=Gasse::whereBetween('fecha', [$primerDia, $ultimoDia])->sum('pm10'); //Aca obtengo total ventas gas a Tgs Celda J44 consumo
        $consumo=$totalpm10-$totalpm316; //Celda J45 total    
        $totalGas=$consumo+$totalpm316; //Celda J45 total      
        $totalGral=0; //total gral corresponde a valor celda D39

        //recorro cada pozo gas dia a dia
        foreach($pozos as $p){          
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
                  'dia' =>date("Y-m-d", $i),
                  'fecha' => date("Y-m-d", $i),
                  'cb' =>$m3Control->gas_neto_mt3, //celda b1 a final mes
                  'cc'=>0,
                  'cd'=>0,                
                  'ce'=>$m3Control->agua_neto_24, //celda e1
                  'totalM' => $total, //celda b35
                  'totalG' => $totalGral+$totalGral+$total,
                  'dias' =>$dias,
                  'v_util'=> $this->buscaParada(date("Y-m-d", $i), $p->id),
                  
                  ];             
                  $calculo[]=$result;
            }            
            $totalGral=$totalGral+$total;
          
        }
       
        //Acá termine recorrer pozo por pozo dia por día
        //Acá guardo datos Parciales
        Calculo::insert($calculo);
        //actualizo todos los registro de tabla cacluloscampo totalG con $totalGral
        Calculo::select('*')->update(['totalG'=>$totalGral,]); 
        //Calculo totales para completar resto campos (me sirve en cierta forma)
          $data= Calculo::select(
            DB::raw('sum(calculos.ce) as tAgua'),
            DB::raw('sum(calculos.cb) as tgas'),
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
            'consumo' => $totalpm10-$totalpm316,
            'vta_std' =>$totalpm316,
            'total_gas' => $totalpm316+$consumo, //celda j45
            'total35' =>  ($totalpm316+$consumo)*$porceWell/100, //sumatoria celda b35
            
            
          ];
          //acá obtengo porcentaje final de cada pozo
          $porcePorpozo[]=$result;      
          $this->finCalculosGas($totalGas,$porcePorpozo, $ultimoDia,$dias,$consumo);
        }        
      }
    
      private function finCalculosGas($totalGas, $porcePorpozo, $ultimoDia, $dias,$consumo){
      
            //ahora relleno resto celdas tabla
            foreach($porcePorpozo as $p){ 
              //aca empieza un pozo
              $results=Calculo::select('*')->where(['well_id' => $p['well_id']])->orderBy('fecha', 'asc')->get();
              $totalPozo=Calculo::select('*')->where(['well_id' => $p['well_id']])->where(['fecha' =>$ultimoDia])->first();
             
              $prodReal=Calculo::select(
                DB::raw('sum(calculos.totalM) as prod_real'),         
                DB::raw("calculos.fecha"),
                )
                ->where('calculos.fecha','=', $ultimoDia)
                ->groupBy('calculos.fecha')
                ->first();  
                //con esto calculo celda B36 % 
                $porcePorPozo= floatval($totalPozo->totalM)/floatval($prodReal->prod_real)*100; 
                //con esto calculo celda D36 o B37 % que es produccion gas
                $prodGaspozo=$totalGas*$porcePorPozo/100; 
               
              
              foreach($results as $r){
              //acá empieza un día de un pozo
                
                Calculo::query()
                ->where('well_id', $p['well_id'])           
                ->update([
                    "cc" => floatval($r['cb']) *100/ floatval($totalPozo->totalM),
                    "cd" =>(floatval($r['cc']))*$prodGaspozo /100,
                ]);
              }  
              
            }
            $prodGas=Calculo::where(['well_id' => $p['well_id']])->sum('cd');
            $prodAgua=Calculo::where(['well_id' => $p['well_id']])->sum('ce');
            $vidaUtil=Calculo::where(['well_id' => $p['well_id']])->sum('v_util');
            $datosWell=Well::where(['id' => $p['well_id']])->first();
      
            $resultFinal=[
              'area_id' =>1,
              'well_id' =>$p['well_id'],
              'pozo' => $totalPozo->pozo, // nombre pozo
              'idpozo' => $datosWell->idpozo, //idpozo ddjj
              'prod_pet' => 0, //producciion petroleo
              'prod_gas' =>$prodGaspozo ,// produccion gas =sumatoria campo mt3gas_declara tabla calculos por pozo
              'prod_agua' => $prodAgua,
              'iny_agua' =>0,
              'iny_co' =>0,
              'iny_otro' =>0,
              'v_util'=>$dias-$vidaUtil,
              'pist' => 'GS', //Tipo Extraxion Gas Lift por ejemplo
              'pet'=>$datosWell->pet,
              'well_state_id' =>$datosWell->well_state_id
       
            ];
          
            
            //Acá termina un pozo
            Djj::insert($resultFinal);
      }      
 
      public function calcularOil($desde, $hasta){
        $pozos =Well::select('*')->where(['pet'=>'PET','well_state_id' =>8 ])->orderBy('id')->get();
        $primerDia=date_create($desde); 
      
        //fechas para consultas  
        $primerDia=$primerDia->format('Y-m-d');
        $ultimoDia=date("Y-m-t", strtotime($primerDia)); 
        //Fechas para mostrar
        $fechaInicio=strtotime($desde);      
        $fechaFin=strtotime($hasta);
        //para comparar totales con informe mensual el dato que nececito es campo agua y prod bruta real
        $infoMensual=Informem::select('*')->where(['fecha' => $primerDia])->first(); 
        
        //suma total agua pozos Gasiferos, por eso hay que calcular primero el gas
        $totalAguaGas=Djj::sum('prod_agua');
      
        //Total Agua Informe
        $totalAguaInfo=$infoMensual->agua;
        
        //Todal el agua a llegar para que coincida con informe mensual es el siguiente
        $aguaAllegarOil=$infoMensual->agua-$totalAguaGas;
        
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
                'dia' =>date("Y-m-d", $i),
                'fecha' => date("Y-m-d", $i),
                'cb' =>floatval($m3Control->prod_bruta_mt3), 
                'cc'=>floatval($m3Control->agua_emul_por),  
                'cd'=>floatval($m3Control->prod_bruta_mt3-($m3Control->prod_bruta_mt3*$m3Control->agua_emul_por/100)),  
                'ce'=>floatval($m3Control->agua_neto_24), //celda e1
                'totalM' => $total, //celda b35
                'totalG' => $totalGral+$total,
                'dias' =>$dias,
                'v_util'=> $this->buscaParada(date("Y-m-d", $i), $p->id),
                'pet' =>'PET'
                
                ];             
              
                $calculo[]=$result;
          } //termina un pozo todo el mes
        
        
          $totalGral=$totalGral+$total;
        }

       
     
        //Inserto los primeros calculos de todos los pozos y dias hasta columna e
          Calculo::insert($calculo);  
        
          //Acá Tengo B36 9.21 de cada pozo 
          $data=''; //contine totales columna b
          $data= Calculo::select(
            DB::raw('sum(calculos.ce) as tAgua'),
            DB::raw('sum(calculos.cb) as tBruta'),
            DB::raw('sum(calculos.cc) as tporceAguas'),
            DB::raw('sum(calculos.cd) as tNeta'),
            DB::raw("calculos.well_id"),
            )
            ->groupBy('calculos.well_id')
            ->orderBy('calculos.well_id')
            ->get(); 
          //estos son los 26.81 celda b44
          $dataBruta=Calculo::select(
            DB::raw('sum(calculos.cb) as tBruta'),
          )->first();
          
          //recorro totales cada pozo y saco calculos
          $totalesParaCalculos=[];

          foreach($data as $d){
          
            $dataParaCalculos=[
              'well_id' =>$d->well_id,
              'b36' => $d->tBruta,
              'b37' =>$d->tBruta*100/ $dataBruta->tBruta,
              'b38' =>$infoMensual->prod_bruta*$d->tBruta/ $dataBruta->tBruta,
              'b44' => $dataBruta->tBruta, //b44
              'b55' =>$infoMensual->prod_bruta, //b55
              'b58' =>  $totalAguaInfo, //total agua informe mensual 10.22
              'b59' => $totalAguaGas, //Agua Gasiferos  7.75
              'b60' =>$totalAguaInfo-$totalAguaGas, //a lo que tengo que llegar agua enero 10.22 - total agua Gas Enero=

      
            ];
            $totalesParaCalculos[]=$dataParaCalculos;
          }
          foreach($totalesParaCalculos as $c){
          
            $dataUpdate=Calculo::select('*')->where(['well_id' => $c['well_id']])->orderby('fecha', 'asc')->get();
            //recorro día por dia pozo por pozo
              foreach($dataUpdate as $d){
                $cg=floatval($c['b38']) * (floatval($d['cb'])*100/floatval($c['b36'])) /100 ;
                Calculo::query()
                ->where('well_id' , $c['well_id']) 
                ->where('fecha','=', $d['fecha'] )          
                ->update([                 
                    "cf" => floatval($d['cb'])*100/floatval($c['b36']),      
                    "cg" => $cg,      
                ]); 
            } 
            //dd($aguaAllegarOil); b60
            $dataUpdate=Calculo::select('*')->where(['well_id' => $c['well_id']])->orderby('fecha', 'asc')->get();
            foreach($dataUpdate as $d){
              //dd($d);
              $totalG36=Calculo::where(['well_id' => $c['well_id']])->sum('cg');           
              $porceAguaPozo=Well::select('porce_agua')->where(['id' => $c['well_id']])->value('porce_agua');
              $ci= floatval($aguaAllegarOil)*floatval($porceAguaPozo)/100; //K47  
              $l47=$ci*100/$totalG36;
                      
              Calculo::query()
              ->where('well_id' , $c['well_id']) 
              ->where('fecha','=', $d['fecha'] )          
              ->update([   
                  "ch" => floatval($d['cg'])-($ci*100/$totalG36)*floatval($d['cg']/100),            
                  "ci" =>$l47,              
                  "cj" =>($ci*100/$totalG36)*floatval($d['cg'])/100
              ]); 
          } 
        

       } 
        //acá terminé de hacer todos los calculos ahora armar resumen
      }

      //Función que busca el control de pozo del día, si no lo hay, busca el proximo anterior
      private function buscaControl($fecha, $idWell){
        //busco si hay un control con esa fecha y pozo
        $count =WellControl::where(['fecha'=>$fecha, 'well_id'=>$idWell])->count();     

        if ($count==1){
          $result=WellControl::where(['fecha'=>$fecha, 'well_id'=>$idWell])->first();
          //if($idWell==23 && $fecha=='2023-03-04'){
          //  dd($result);
         // }
          return $result;
        }else{
          $result=WellControl::where('fecha','<',$fecha)->where('well_id','=', $idWell)->orderBy('fecha','desc')->first();
          //if($idWell==24 && $fecha=='2023-03-01'){
          //  dd($result);
          //}
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

    public function render(){
        return view('livewire.ddjj-component',[
            'wells' => Well::all(),            
        ]);   
    }
}

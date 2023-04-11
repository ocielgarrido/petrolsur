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
use App\Models\WellState;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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

    //Datos a Devolver
    public $datosF;
    public $gas=0;
    public $informe;
    public $totales;

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
      $this->gas=0;

    }

    public function render(){
      if($this->gas==1){   
            
        $this->datosF=djj::select('*')->get();
        return view('livewire.ddjj-component',[
            'datos' => $this->datosF,
            'informe' =>$this->informe,
            'totales' => $this->totales
                           
        ]);
      }else{
        return view('livewire.ddjj-component');

      } 
     
    }


    public function calcularDdjj(){         
      $this->resetErrorBag();
      $this->validate();

      switch ($this->tipo) {       
        case '1':
          //Capitulo IV TXT
          
           $result=$this->verificarInforme($this->desde);
          //primero verifico si está informe creado, de ser así continuo
          if($result==true){
            DB::table('calculos')->delete();
            DB::table('djjs')->delete();
            $this->calcularGas($this->desde,$this->hasta);
        //    DB::table('calculos')->delete();
       //     $this->calcularOil($this->desde,$this->hasta); 
       //     $this->escribirTxt($this->desde);
          }else{
            session()->flash('msg-error','No existe informe Mensual, debe generar antes de seguir!!');
          } 
           break;
        case '2':
          //Regalias
          break;
        case '3':
          //Cesco
          break;
    
      }
    }
    //Función que genera el txt
    public function escribirTxt($desde){
      $periodo=date_create($desde);         
      $filename=$periodo->format('Y-m');     
      $fecha=$periodo->format('Y-m-d');  

      $contents=Djj::all();
      $informe=Informem::where(['fecha' =>$fecha])->first(); 
      $filename= Storage::disk('ddjj')->path('CIV\\' .$informe->fileCapIV);  //Ubicacion del txt  
      
      if(!File::exists($filename)){
        $filename=$periodo->format('Y-m');
        Storage::disk('ddjj')->put('CIV/CAP_IV_PetrolSur_' . $filename .  '.txt','');
        $filename= Storage::disk('ddjj')->path('CIV\\' .$informe->fileCapIV);  //Ubicacion del txt  

      }
      $count=djj::count();
      $file = fopen($filename, "w");
      foreach($contents as $c) {
        $linea=$c->idpozo .';' . round($c->prod_pet,2) .';' . round($c->prod_gas,2) .';0.00;0.00;0.00;0.00;0.00;' . round($c->v_util,2) . $c->pist . ';' . $c->well_state_id . ';' . $c->pet. ';';       
        fwrite($file, $linea . PHP_EOL);
      }
      fclose($file);
      // $i=0;
      //  while($i <= $count){
      //    $linea=$c->idpozo .';' . round($c->prod_pet,2) .';' . round($c->prod_gas,2) .';0.00;0.00;0.00;0.00;0.00;' . round($c->v_util,2) . $c->pist . ';' . $c->well_state_id . ';' . $c->pet. ';';       
      //    fwrite($file, $linea . PHP_EOL);
      //     $i++;
      //  }
        


    }

    //Función que verifica que informe mensual existe    
    public function verificarInforme($desde){
      $periodo=date_create($desde);         
      $filename=$periodo->format('Y-m');     
       $fecha=$periodo->format('Y-m-d');  
     
      $count=Informem::where(['fecha' => $fecha])->count();
      if($count==1){
        Storage::disk('ddjj')->put('CIV/CAP_IV_PetrolSur_' . $filename .  '.txt', 'Contents');
        Informem::query()
        ->where('fecha',$fecha)           
        ->update([
            'fileCapIV'=> 'CAP_IV_PetrolSur_' . $filename .  '.txt',
          ]);
        return true; 
      }else{
       
        return false;
      }
    } 

    //Funcion que calcula Gas a informar
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
        $infoMensual=Informem::select('*')->where(['fecha' => $primerDia])->first();         
       
       
        //recorro cada pozo gas dia a dia
        $totalGral=0;
        foreach($pozos as $p){          
          $total=0; //corresponde a celda a celda b35 lo que sumand todas las B
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
              //86400 es el número de segundos que tiene 1 día
              $dias=($fechaFin-$fechaInicio)/86400; 
              $dias=$dias +1;
              //de aca saco valores columna  D y E de excel
              $m3Control=$this->buscaControl(date("Y-m-d", $i), $p->id); //si no encuentro control del día, me devuelve datos control proximo anterior
              $diasParada=$this->buscaParada(date("Y-m-d", $i), $p->id);

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
                  'totalM' => $total, //celda b35 total mes a ajustar
                  'dias' =>$dias,
                  'tef'=> $diasParada /24,
                  'totalG' => $totalGral+$totalGral+$total, //total controles pozo
                  'totalR' =>$infoMensual->tgas, // total al cual debo llegar
                  'porce'  => 0, //porcentaje 
                  'cbA'    =>0,  // Al cual debo llegar que será el total
                  'id_control' => $m3Control->id
                  
                  ];             
                  $calculo[]=$result;

            }   //termina un mes de un pozo      
            $totalGral=$totalGral+$total;
            
        } //teminalos pozos
        
        Calculo::insert($calculo); 
        Calculo::select('*')->update(['totalG'=>$totalGral,]); 
       
      $pozos=Calculo::where(['fecha' =>$ultimoDia])->get();
      foreach($pozos as $p){          
        $porce=round($p->totalM*100/$p->totalG,2);
        $cbA=$p->totalR*$porce/100;
        Calculo::where(['well_id' =>$p->well_id])->update(['porce'=>$porce,]); 
        Calculo::where(['well_id' =>$p->well_id])->update(['cbA'=>$cbA,]);    
        Calculo::where(['well_id' =>$p->well_id])->update(['totalM'=>$p->totalM,]);    
         
      }
      //calculo ajustes controles
      foreach($pozos as $p){  
        
        $porce=round($p->cb*100/$p->totalM,2);
        $ajuste=$p->cbA*$porce/100;
       // $this->ajustarControlGas($p->id,$ajuste);
        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){   
          Calculo::where(['id' =>$p->id])->update(['porce_diario'=>$porce,]); 
          Calculo::where(['id' =>$p->id])->update(['ajuste_gas'=>$ajuste,]);  
        
        } 
    }

      //Calculo totales para completar resto campos (me sirve en cierta forma)
          $data= Calculo::select(
            DB::raw('sum(calculos.ce) as tAgua'),
            DB::raw('avg(calculos.cbA) as tgas'),
            DB::raw("calculos.well_id"),
            )
          ->groupBy('calculos.well_id')
          ->orderBy('calculos.well_id')
          ->get(); 
        dd($data);  
        $porcePorpozo=[];  
          
        foreach($data as $d){                    
          //acá obtendo co d->tgas valor celda b35  de cada pozo  
          $totalB=Calculo::sum('cb');         
          $porceWell=$d->tgas*100/$totalB; //Acá obtengo porcentaje por pozo celda b36
          $pozo=$d['well_id']; //tengo id pozo
          $sumaB=Calculo::where(['well_id'=>$pozo])->sum('cb'); 
          $sumaE=Calculo::where(['well_id'=>$pozo])->sum('ce');
          $tef=Calculo::where(['well_id'=>$pozo])->sum('tef');               
          $result=[
            'well_id' =>$pozo,
            'porce_well' => round($porceWell,2), //celda b36
            'consumo' => $infoMensual->cgas,
            'vta_std' => $infoMensual->pm316,
            'total_gas' =>  $infoMensual->tgas, //celda j45
            'sumab' =>$sumaB,
            'total35' => round(( ($infoMensual->pm316+$infoMensual->cgas)*$porceWell/100),2), //sumatoria celda b35
            'prod_real' => $totalB,
            'agua_declara' => $sumaE,
            'tef' =>$tef           
          ];          
          //acá obtengo porcentaje final de cada pozo
          $porcePorpozo[]=$result;
         // $this->finCalculosGas($infoMensual->tgas,$porcePorpozo);
        } 
        //Ahora lleno tabla que generará txt 
        foreach($porcePorpozo as $p){ 
          $datosWell=Well::where(['id'=>$p['well_id']])->first();
          $arap=WellState::where(['id' => $datosWell->well_state_id])->first();

          $resultFinal=[
            'area_id' =>1,
            'well_id' =>$p['well_id'],
            'pozo' => $datosWell->pozo, // nombre pozo
            'idpozo' => $datosWell->idpozo, //idpozo ddjj
            'prod_pet' => 0, //producciion petroleo
            'prod_gas' =>$p['total35'] ,// produccion gas =sumatoria campo mt3gas_declara tabla calculos por pozo
            'prod_agua' => $p['agua_declara'],
            'iny_agua' =>0,
            'iny_co' =>0,
            'iny_otro' =>0,
            'v_util'=>$dias-$p['tef'],
            'pist' => 'GS', //Tipo Extraxion Gas Lift por ejemplo
            'pet'=>$datosWell->pet,
            'well_state_id' =>$arap->codigo     
          ];
          Djj::insert($resultFinal);
        }

        
    }
     
    //Funcion que calcula Oil Deshidratado a informar
    public function calcularOil($desde, $hasta){
        DB::table('calculos')->delete();
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
        
        
        foreach($pozos as $p){     
          //recorro cada pozo oil dia a dia
          $total=0; //corresponde a celda a celda b35 lo que sumand todas las B
          for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            //86400 es el número de segundos que tiene 1 día
            $dias=($fechaFin-$fechaInicio)/86400; 
            $dias=$dias +1;
            //de aca saco valores columna  D y E de excel
            $m3Control=$this->buscaControl(date("Y-m-d", $i), $p->id); //si no encuentro control del día, me devuelve datos control proximo anterior
            $diasParada=$this->buscaParada(date("Y-m-d", $i), $p->id);

            // $total=$total+$m3Control;
            $total=$total+$m3Control->prod_bruta_mt3;           
              $result=[ 
                //Campos para Oil
                'yacimiento_id' =>$p->yacimiento_id,
                'well_id' =>$p->id, 
                'pozo' =>$p->pozo, 
                'dia' =>date("Y-m-d", $i),
                'fecha' => date("Y-m-d", $i),
                'cb' =>floatval($m3Control->prod_bruta_24), 
                'cc'=>floatval($m3Control->agua_emul_por),  
                'cd'=>floatval($m3Control->oil_neto_mt3),  
                'ce'=>floatval($m3Control->agua_neto_24), //celda e1
                'cg' => 0 , //bruta a declarar 
                'ch' => 0 , //neta a declarar 
                'totalM' => $total, //celda b35
                'totalM' => $total, //celda b35
                'totalG' => 0,
                'dias' =>$dias,
                'tef'=> $diasParada /24,
              
                ];             
              
                $calculo[]=$result;
          } //termina un pozo todo el mes         
          
        } 
       
        Calculo::insert($calculo);  
     
          //Acá Tengo B36 9.21 de cada pozo 
          $data=''; //contine totales columna b
          $data= Calculo::select(
            DB::raw('sum(calculos.ce) as te'),
            DB::raw('sum(calculos.cb) as tb'),
            DB::raw('sum(calculos.cc) as tc'),
            DB::raw('sum(calculos.cd) as td'),
            DB::raw("calculos.well_id"),
            )
          ->groupBy('calculos.well_id')
          ->orderBy('calculos.well_id')
          ->get(); 
         
          //recorro totales cada pozo y saco calculos
          $porcePorpozo=[];  

          foreach($data as $da){
            $pozo=$da['well_id']; //tengo id pozo
            $tef=Calculo::where(['well_id'=>$pozo])->sum('tef'); 
            $tcpb=Calculo::sum('cb');  //total control pozo bruta 
            $tcpn=Calculo::sum('cd');  //total control pozo neta 
            $tcpa=Calculo::sum('ce');  //total control pozo agua 
            $porJajuste=Well::select('porce_agua')->where(['id'=>$pozo])->first();

             $result=[
              'well_id' =>$da->well_id,
              'b34' => $da['tb'],
              'b36' => round($infoMensual->oilb/100,2)*(round($da['tb']*100/$tcpb,2)),
              'b33' => $da['tb'],
              'd36' => $da['td'],
              'c36' => $da['tc'],    
              'e36' => $da['te'],
              'tef' => $tef,
              'tcpb'=>$tcpb,
              'tcpn'=>$tcpn,
              'tcpa'=>$tcpa,
              '%pozo'=>round($da['tb']*100/$tcpb,2),
              'tbm' =>$infoMensual->oilb, //total bruta mes
              'oilhm' =>$infoMensual->oilH, //total oilH mes
              'oildm' =>$infoMensual->oilD, //total oilD mes
              'aguam' =>$infoMensual->agua, //total agua mes
              'tagas' =>$totalAguaGas, //Total agua calculada con gasiferos
              'taguap'=> $infoMensual->agua - $totalAguaGas, // agua a la que debemos llegar
              'tbw' =>round($infoMensual->oilb/(round($da['tb']*100/$tcpb,2)),2), //total bruta pozo
              '%ajuste' => $porJajuste->porce_agua, //porcentaje ajuste agua del pozo
              'mtagua' => ($infoMensual->agua - $totalAguaGas)*($porJajuste->porce_agua/100) //agua a informar

 
            ];

            $porcePorpozo[]=$result;  

          }
         
          foreach($porcePorpozo as $p){
             $pozo=Well::where(['id' => $p['well_id']])->first();
              $resultFinal=[
                'area_id' =>1,
                'well_id' =>$p['well_id'],
                'pozo' => $pozo->pozo, // nombre pozo
                'idpozo' => $pozo->idpozo, //idpozo ddjj
                'prod_pet' => $p['%ajuste'] *$p['oildm'], //producciion petroleo
                'prod_gas' =>0 ,// produccion gas =sumatoria campo mt3gas_declara tabla calculos por pozo
                'prod_agua' => $p['mtagua'],
                'iny_agua' =>0,
                'iny_co' =>0,
                'iny_otro' =>0,
                'v_util'=>0,
                'pist' => 'GS', //Tipo Extraxion Gas Lift por ejemplo
                'pet'=>$pozo->pet,
                'well_state_id' =>$pozo->well_state->codigo
              ];
              Djj::insert($resultFinal);
          }
        //INSERTO resto pozos que no están en produccion
        $pozos =Well::select('*')->where('well_state_id', '<>', 8 )->orderBy('id')->get();
        foreach ($pozos as $p){
           $result=[
            'area_id' =>1,
            'well_id' =>$p->id,
            'pozo' => $p->pozo, // nombre pozo
            'idpozo' => $p->idpozo, //idpozo ddjj
            'prod_pet' => 0, //producciion petroleo
            'prod_gas' =>0 ,// produccion gas =sumatoria campo mt3gas_declara tabla calculos por pozo
            'prod_agua' => 0,
            'iny_agua' =>0,
            'iny_co' =>0,
            'iny_otro' =>0,
            'v_util'=>0,
            'pist' => 'GS', //Tipo Extraxion Gas Lift por ejemplo
            'pet'=>$p->pet,
            'well_state_id' =>$p->well_state->codigo   


           ];
          
           Djj::insert($result);
          
        }
        $this->datosF=Djj::all();        
        $this->informe=$infoMensual;
        $this->totales= Djj::select(
         DB::raw('sum(djjs.prod_pet) as toil'),
         DB::raw('sum(djjs.prod_gas) as tgas'),
         DB::raw('sum(djjs.prod_agua) as tagua'),
         )   
        ->get('toil','tgas', 'tagua'); 
         $this->gas=1;        
          
        

    }

    //Función que busca el control de pozo del día, si no lo hay, busca el proximo anterior
    private function buscaControl($fecha, $idWell){
        //busco si hay un control con esa fecha y pozo
        $count =WellControl::where(['fecha'=>$fecha, 'well_id'=>$idWell])->count();
        if ($count==1){
          $result=WellControl::where(['fecha'=>$fecha, 'well_id'=>$idWell])->first();     
          //if($idWell==17 && $fecha=='2023-03-27'){
          //  $result=WellControl::where(['fecha'=>$fecha, 'well_id'=>$idWell])->first();  
          //  dd($result);

          //}    
          return $result;
        }else{
          $result=WellControl::where('fecha','<',$fecha)->where('well_id','=', $idWell)->orderBy('fecha','desc')->first();
          return $result;
        } 
    }

    private function buscaParada($fecha, $idWell){
        //busco si hay una parada esa fecha y pozo y devuelve 
        //cantidad de horas y las transforma a fracion de dias
        $count =WellDownTime::where(['fecha'=>$fecha, 'well_id'=>$idWell])->count();
      
        if ($count==1){
          $result=WellDownTime::where(['fecha'=>$fecha, 'well_id'=>$idWell])->first(); 
          return $result->horas;  
        }else{
          return 0;
        } 
    }

    private function ajustarControlGas($id, $valor){
      WellControl::query()
      ->where('id', $id)           
      ->update([
          'gas_neto_mt3'=>$valor,
          'estado' => 'Cerrado',

      ]);

    }

  
}

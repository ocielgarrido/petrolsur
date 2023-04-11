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
    public $calculado=[];
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
            DB::table('calculos')->delete();
            $this->calcularOil($this->desde,$this->hasta); 
            $this->escribirTxt($this->desde);
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
      $this->gas=1;   
      $this->datosF=Djj::all();        
      $this->informe=Informem::select('*')->where(['fecha' => $fecha])->first();    ;
      $this->totales= Djj::select(
       DB::raw('sum(djjs.prod_pet) as toil'),
       DB::raw('sum(djjs.prod_gas) as tgas'),
       DB::raw('sum(djjs.prod_agua) as tagua'),
       )   
      ->get('toil','tgas', 'tagua');  
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
        $this->informe=Informem::where(['fecha' => $fecha])->first();
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
        $this->informe=Informem::select('*')->where(['fecha' => $primerDia])->first();         
       
       
        //recorro cada pozo gas dia a dia
        $totalGral=0;
        foreach($pozos as $p){          
          $total=0; //corresponde a celda a celda b35 lo que sumand todas las B
            for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
              //86400 es el número de segundos que tiene 1 día
              $dias=($fechaFin-$fechaInicio)/86400; 
              $dias=$dias +1;
              //de aca saco valores columna  D y E de excel
              $controlP=$this->buscaControl(date("Y-m-d", $i), $p->id); //si no encuentro control del día, me devuelve datos control proximo anterior
              $diasParada=$this->buscaParada(date("Y-m-d", $i), $p->id);

              // $total=$total+$controlP;
              $total=$total+$controlP->gas_neto_mt3;           
                $result=[ 
                  //Campos para gas
                  'yacimiento_id' =>$p->yacimiento_id,
                  'well_id' =>$p->id, 
                  'pozo' =>$p->pozo, 
                  'dia' =>date("Y-m-d", $i),
                  'fecha' => date("Y-m-d", $i),
                  'cb' =>round($controlP->gas_neto_mt3,2), //celda b1 a final mes
                  'cc'=>0,
                  'cd'=>0,                
                  'ce'=>round($controlP->agua_neto_24,2), //celda e1
                  'totalM' => $total, //celda b35 total mes a ajustar
                  'dias' =>$dias,
                  'tef'=> $diasParada /24,
                  'totalG' =>round(($totalGral+$totalGral+$total),2), //total controles pozo
                  'totalR' =>round($this->informe->tgas,2), // total al cual debo llegar
                  'porce'  => 0, //porcentaje 
                  'cbA'    =>0,  // Al cual debo llegar que será el total
                  'id_control' => $controlP->id
                  
                  ];             
                  $calculo[]=$result;
             
            }   //termina un mes de un pozo      
            $totalGral=$totalGral+$total;
            
        } //teminalos pozos
      
        Calculo::insert($calculo); 
        Calculo::select('*')->update(['totalG'=>round($totalGral,2)]); 
       
      $pozos=Calculo::where(['fecha' =>$ultimoDia])->get();
      
      foreach($pozos as $p){          
        $porce=round($p->totalM*100/$p->totalG,2);
        $cbA=round($p->totalR*$porce/100);
        Calculo::where(['well_id' =>$p->well_id])->update(['porce'=>round($porce,2),]); 
        Calculo::where(['well_id' =>$p->well_id])->update(['cbA'=>round($cbA,2),]);    
        Calculo::where(['well_id' =>$p->well_id])->update(['totalM'=>round($p->totalM,2),]);    
         
      }
      //calculo ajustes controles
      $pozos=Calculo::orderBy('id')->get();
      foreach($pozos as $p){  
        
        $porce=round($p->cb*100/$p->totalM,2);
        $ajuste=round($p->cbA*$porce/100,2);
       // $this->ajustarControlGas($p->id,$ajuste);
        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){  

          Calculo::where(['id' =>$p->id])->update(['porce_diario'=>round($porce,2),]); 
          Calculo::where(['id' =>$p->id])->update(['ajuste_gas'=>round($ajuste,2),]);  
        
        } 
      }

      //Calculo totales para completar resto campos (me sirve en cierta forma)
          $data= Calculo::select(
            DB::raw('sum(calculos.ce) as tAgua'),
            DB::raw('avg(calculos.cbA) as tGas'),
            DB::raw("calculos.well_id"),
            )
          ->groupBy('calculos.well_id')
          ->orderBy('calculos.well_id')
          ->get();        
    
        //Ahora lleno tabla que generará txt 
        foreach($data as $p){ 
          
          $datosWell=Well::where(['id'=>$p['well_id']])->first();
          $arap=WellState::where(['id' => $datosWell->well_state_id])->first();

          $resultFinal=[
            'area_id' =>1,
            'well_id' =>$p['well_id'],
            'pozo' => $datosWell->pozo, // nombre pozo
            'idpozo' => $datosWell->idpozo, //idpozo ddjj
            'prod_pet' => 0, //producciion petroleo
            'prod_gas' =>round($p->tGas/1000,2) ,// produccion gas  en miles
            'prod_agua' =>round($p->tAgua,2), //produccion agua
            'iny_agua' =>0,
            'iny_co' =>0,
            'iny_otro' =>0,
            'v_util'=>0, //$dias-$p['tef'],
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
      //  $pozos =Well::select('*')->where(['pet'=>'PET','id' =>2])->orderBy('id')->get();
        $primerDia=date_create($desde); 
       
        //fechas para consultas  
        $primerDia=$primerDia->format('Y-m-d');
        $ultimoDia=date("Y-m-t", strtotime($primerDia)); 
        //Fechas para mostrar
        $fechaInicio=strtotime($desde);      
        $fechaFin=strtotime($hasta);
       
        //suma total agua pozos Gasiferos, por eso hay que calcular primero el gas
        $totalAguaGas=Djj::sum('prod_agua');               
        //Todal el agua a llegar para que coincida con informe mensual es el siguiente
        $aguaAllegarOil=round($this->informe->agua-$totalAguaGas,2); //agua petroleros
       
        //recorro cada pozo gas dia a dia
        $totalGral=0;
        foreach($pozos as $p){     
          //recorro cada pozo oil dia a dia
          $total=0; //corresponde a celda a celda b35 lo que sumand todas las B
          for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            //86400 es el número de segundos que tiene 1 día
            $dias=($fechaFin-$fechaInicio)/86400; 
            $dias=$dias +1;
            //de aca saco valores columna  D y E de excel
            $controlP=$this->buscaControl(date("Y-m-d", $i), $p->id); //si no encuentro control del día, me devuelve datos control proximo anterior
            $diasParada=$this->buscaParada(date("Y-m-d", $i), $p->id);

            // $total=$total+$controlP;
              $total=$total+$controlP->prod_bruta_mt3;                      
              $result=[ 
                //Campos para Oil
                'yacimiento_id' =>$p->yacimiento_id,
                'well_id' =>$p->id, 
                'pozo' =>$p->pozo, 
                'dia' =>date("Y-m-d", $i),
                'fecha' =>date("Y-m-d", $i),
                'cb' =>round($controlP->prod_bruta_24,2), 
                'cc'=>round($controlP->agua_emul_por,2),  
                'cd'=>round($controlP->oil_neto_mt3,2),  
                'ce'=>round($controlP->agua_neto_24,2), //celda e1
                'cg' => 0 , //bruta a declarar 
                'ch' => 0 , //neta a declarar 
                'totalM' => $total, //celda b35
                'totalG' => $aguaAllegarOil,
                'totalR' =>$this->informe->oilD, // total al cual debo llegar
                'dias' =>$dias,
                'tef'=> $diasParada /24,
                'id_control' =>  $controlP->id
              
                ];             
              
                $calculo[]=$result;
               
          } //termina un pozo todo el mes  
          $totalCB = array_sum(array_column($calculo, 'cb'));
          $totalCC = array_sum(array_column($calculo, 'cc'));
          $totalCD = array_sum(array_column($calculo, 'cd'));
          $totalCE = array_sum(array_column($calculo, 'ce'));
          $resultC=[
            'yacimiento_id' =>$calculo[0]['yacimiento_id'],
            'well_id' =>$calculo[0]['well_id'], 
            'pozo' =>$calculo[0]['pozo'],
            'dia' =>$calculo[0]['dia'],
            'cb' =>$totalCB, 
            'cc'=>$totalCC,  
            'cd'=>$totalCD,  
            'ce'=>$totalCE, //celda e1
            'cg' => 0 , //bruta a declarar 
            'ch' => 0 , //neta a declarar 
            'totalM' =>0, // $total, //celda b35
            'totalG' => $calculo[0]['totalG'],
            'totalR' =>$calculo[0]['totalR'], // total al cual debo llegar
            'dias' =>$calculo[0]['dias'],
            'tef'=> $calculo[0]['tef'],
            'id_control' =>  $calculo[0]['id_control'],

          ]; 
          $calculado[]=$resultC;
          
          /* $key = "tcb";
          $value = $totalCB;
          $calculo[$key] = $value;
          dd($calculo); */
         
          $totalGral=$totalGral+$total;
        } 
        
        Calculo::insert($calculo); 
        Calculo::select('*')->update(['totalG'=>round($totalGral,2),]); 
        $pozos=Calculo::where(['fecha' =>$ultimoDia])->get();
      
        foreach($pozos as $p){          
            $porce=round($p->totalM*100/$p->totalG,2);
            $cbA=round($this->informe->oilB*$porce/100,2);
            Calculo::where(['well_id' =>$p->well_id])->update(['porce'=>(round($porce,2))]); 
            Calculo::where(['well_id' =>$p->well_id])->update(['cbA'=>round($cbA,2)]);    
            Calculo::where(['well_id' =>$p->well_id])->update(['totalM'=>round($p->totalM,2)]);    
            
        }
        
       
       //Para ver resumen por pozo
        $data= Calculo::select(
        DB::raw('sum(calculos.cd) as oilB'),
        DB::raw('sum(calculos.ce) as aguaM3'),
        DB::raw('avg(calculos.cbA) as cbA'),
  
        DB::raw("calculos.well_id"),
        )
        ->groupBy('calculos.well_id')
        ->orderBy('calculos.well_id')
        ->get(); 
        
          //ahora obtengo totales de pozo
        foreach($data as $d){            
            Calculo::where(['well_id' =>$d->well_id])->update(['oilB'=>round($d->oilB,2)]); 
            Calculo::where(['well_id' =>$d->well_id])->update(['aguaM3'=>round($d->aguaM3,2)]);    
        }

        //Vuelvo a recorrer pozo por pozo día por día
        $pozos=Calculo::orderBy('id')->get();
        foreach($pozos as $p){     
              
          for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            
            $dias=($fechaFin-$fechaInicio)/86400; 
            $dias=$dias +1; 
            $cF=round(($p->cb*100/$p->totalM),2);
            Calculo::query()
            ->where('id', $p->id)           
            ->update([
                'cf' =>round($cF,2), 
                'cg'=>round(($cF*$p->cbA/100),2),              
 
            ]);
           } //termina un pozo todo el mes         
         
        } 
        $pozos=Calculo::orderBy('id')->get();
        foreach($pozos as $p){     
          
          $pCalculo=round(($aguaAllegarOil*$p->porce/100),2); //ok
          $totalG=Calculo::where(['well_id' => $p->well_id])->sum('cg');          
          $totalG=round($totalG,2);
          $porceCalculo=round(($pCalculo*100/$totalG),2);
          for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){            
            $cF=round(($p->cb*100/$p->totalM),0);          
            Calculo::query()
            ->where('id', $p->id)           
            ->update([
                'ci' =>round($porceCalculo,2), 
                'cj'=>round(($porceCalculo*$p->cg/100),2),
                'ch'=>round($p->cg,2)- (round($porceCalculo,2)*($p->cg/100)) //es la que se informa en CIV
            ]);
           } //termina un pozo todo el mes         
         
        } 
        
       
        ///Datos Finales
        $data= Calculo::select(
          DB::raw('avg(calculos.porce) as porce'),
          DB::raw('sum(calculos.cj) as aguaM3'),
          DB::raw('sum(calculos.cf) as porcea'),
   
          DB::raw("calculos.well_id"),
          )
          ->groupBy('calculos.well_id')
          ->orderBy('calculos.well_id')
          ->get(); 
        
        foreach($data as $p){
             $pozo=Well::where(['id' => $p->well_id])->first();
              $resultFinal=[
                'area_id' =>1,
                'well_id' =>$p->well_id,
                'pozo' => $pozo->pozo, // nombre pozo
                'idpozo' => $pozo->idpozo, //idpozo ddjj
                'prod_pet' => round(($p['porce']* $this->informe->oilD/100),2), //producciion petroleo
                'prod_gas' =>0 ,// cero en Oil
                'prod_agua' => $p['aguaM3'],
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

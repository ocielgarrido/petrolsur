<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Well;
use App\Models\WellControl;
use App\Models\Informem;
use App\Models\Calculo;
use App\Models\Gasse;
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

    public function calcularGas(){
      //Elimino datos tablas
      DB::table('calculos')->delete();
      //Obtengo pozos activos de gas
      $pozos =Well::where(['tipo'=>'GAS','well_state_id' =>8 ])->get();
      $primerDia=date_create($this->desde);   
      $primerDia=$primerDia->format('Y-m-d');       
      $fechaInicio=strtotime($this->desde);      
      $fechaFin=strtotime($this->hasta);
      //86400 es el número de segundos que tiene 1 día
      $totalGral=0;
      foreach($pozos as $p){
        $total=0;
       
          for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $m3Control=$this->buscaControl(date("Y-m-d", $i), $p->id);
            $total=$total+$m3Control;
            $totalGral=$totalGral+$total;           
              $result=[ 
                //Campos para gas
                'yacimiento_id' =>$p->yacimiento_id,
                'well_id' =>$p->id, 
                'pozo' =>$p->pozo, 
                'dia' =>date("d-m-Y", $i),
                'fecha' => date("Y-m-d", $i),
                'm3gas_control' =>$m3Control,
                'porce_prod'=>0,
                'mt3gas_declara'=>0,
                'agua_declara'=>0.05,
                'total_mes' => $total,
                'total_gral' => $totalGral,
                // campos para petroleo
               // 'bruta_m3' => 0,
               // 'agua' =>0,
                //'neta_m3' =>0,
               // 'agua_m3' =>0,
               // 'porce_total' =>0,
               // 'bruta_declara' =>0,
              //  'neta_declara' =>0,

                ];
                $ultimoDia= date("Y-m-d", $i);
               
                $calculo[]=$result;
          }
         
    
      }

      
     //Acá guardo datos
     // Calculo::insert($calculo);  
     //Aca calculo total de todos los pozos
     $totalMes=Calculo::where(['fecha'=> $ultimoDia])->sum('total_mes');
     //Aca obtengo total ventas gas a Tgs
     $totalVenta=Gasse::whereBetween('fecha', [$primerDia, $ultimoDia])->sum('pm316');
            //Calculo totales para completar resto campos 
            $data= Calculo::select(
              DB::raw('sum(calculos.agua_declara) as tagua'),
              DB::raw('sum(calculos.m3gas_control) as tgas'),
              DB::raw("calculos.well_id"),
              )
               ->groupBy('calculos.well_id')
              ->orderBy('calculos.well_id')
              ->get(); 

      foreach($data as $d){
        $updateWell= Calculo::query()->where('well_id', $d->well_id)->orderBy('fecha','asc')->get();  
         //$d=tengo tGas y tAgua por well
         $porceWell=$d->tgas*100/$totalMes; //Acá obtengo porcentaje por pozo
          //Acá hago calculos pero me faltan datos como el consumo de gas
         foreach($updateWell as $w){         
           $row=Calculo::find($w['id']);            
           $row->porce_prod=$row->m3gas_control*100/$d->tgas;
           $row->mt3gas_declara=($row->m3gas_control*100/$d->tgas);
           $row->save();
         }
       
      }        
     // dd($data);
      
    }
    //Función que busca el control de pozo del día, si no lo hay, busca el proximo anterior
    private function buscaControl($fecha, $idWell){
      //busco si hay un control con esa fecha y pozo
      $count =WellControl::where(['fecha'=>$fecha, 'well_id'=>$idWell])->count();
      if ($count==1){
        $result=WellControl::where(['fecha'=>$fecha, 'well_id'=>$idWell])->first();
        return $result->gas_neto_mt3;
      }else{
        $result=WellControl::where('fecha','<',$fecha)->where('well_id','=', $idWell)->orderBy('fecha','desc')->first();
        return $result->gas_neto_mt3;
      } 
    }

    public function render()
    {
        return view('livewire.ddjj-component',[
            'wells' => Well::all(),
     
            
        ]);   
    }
}

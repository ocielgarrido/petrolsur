<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Well;
use App\Models\WellControl;
use Carbon\Carbon;
use DateTime;

class WellControlCreate extends Component
{
    public $wellcontrol;
    public $wellcontrolId;
    public $well;
    public $action;
    public $button;
    public $fechaHoy,$primerDia;
    


   
    protected function getRules(){   
        if( $this->action == "updateWellControl"){
            $rules = [
                'wellcontrol.fecha' => 'required|min:10|max:100|unique:well_controls,fecha,' .$this->wellcontrolId,
            ];
        }else{
            $rules = [
                'wellcontrol.fecha' => 'required|min:10|max:10|unique:well_controls,fecha',
            ];

        }
        return array_merge([
            'wellcontrol.area_id' => 'required',
            'wellcontrol.well_id' => 'required',
            'wellcontrol.horas'   => 'required',
            'wellcontrol.prod_bruta_mt3' => 'required',
            'wellcontrol.agua_emul_por' => 'required',
            'wellcontrol.oil_neto_mt3' => 'required',
            'wellcontrol.agua_neto_mt3' => 'required',
            'wellcontrol.gas_neto_mt3' => 'required',
            'wellcontrol.carrera' => 'required',
            'wellcontrol.gpm' => 'required',
            'wellcontrol.orificio' => 'required',
            'wellcontrol.prod_bruta_24' => 'required',
            'wellcontrol.gas_neto_24' => 'required',
            'wellcontrol.oil_neto_24' => 'required',
            'wellcontrol.agua_neto_24' => 'required',
            'wellcontrol.gas_inyectado' => 'required',
            
   
        ], $rules);

    }


    public function createWellControl(){
        $this->resetErrorBag();
        $this->validate(); 
        // Valido tipo pozo y dato ingresado
        $tipoPozo=Well::select('pet')->where(['id' => $this->wellcontrol->well_id])->first();
        if($tipoPozo->pet =="PET" && $this->wellcontrol->prod_bruta_mt3==0){
            session()->flash('msg-error','Favor verifique datos');
            return;
        }
        if($tipoPozo->pet =="GAS" && $this->wellcontrol->gas_neto_mt3==0){
            session()->flash('msg-error','Favor verifique datos');
            return;            
        }

        $brutamt3=round($this->wellcontrol->prod_bruta_mt3,2);
        $aguamt3=round(($brutamt3*$this->wellcontrol->agua_emul_por/100),2);
        $oilmt3=round(($brutamt3-$aguamt3),2);

        $bruta24=round(($this->wellcontrol->prod_bruta_mt3/$this->wellcontrol->horas*24),2);
        $agua24=round(($bruta24*$this->wellcontrol->agua_emul_por/100),2);  

         if( ($bruta24-$agua24)!=0 && ($this->wellcontrol->gas_neto_mt3/$this->wellcontrol->horas*24)!=0){
            $gor=($this->wellcontrol->gas_neto_mt3/$this->wellcontrol->horas*24) / ($bruta24-$agua24);
         }else{
            $gor=0;  
         }
    

        $results=array(
            "area_id" => 1,
            "well_id" => $this->wellcontrol->well_id,
            "fecha" => $this->wellcontrol->fecha,
            "horas" => $this->wellcontrol->horas,
            "agua_emul_por" => $this->wellcontrol->agua_emul_por,
            "prod_bruta_mt3" =>$brutamt3 ,
            "oil_neto_mt3" => $oilmt3,
            "agua_neto_mt3" =>$aguamt3,
            "gas_neto_mt3" => $this->wellcontrol->gas_neto_mt3,
            "gas_inyectado" => $this->wellcontrol->gas_inyectado,
            "gor" => $gor,

            "carrera" => $this->wellcontrol->carrera,
            "gpm" => $this->wellcontrol->gpm,
            "orificio" => $this->wellcontrol->orificio,
            "estado" => 'Creado',
            'updated_at'=>now(),
            'created_at'=>now(),

            "prod_bruta_24" => $bruta24,            
            "agua_neto_24" =>$agua24,
            "oil_neto_24" => round(($bruta24-$agua24),2),
            "gas_neto_24" => $this->wellcontrol->gas_neto_mt3/$this->wellcontrol->horas*24,
    
              
        );
        WellControl::insert($results);    
        $this->emit('saved');
        return redirect()->to('/wellcontrol');

    }

    public function updateWellControl() {
        $this->resetErrorBag();
        $this->validate();
        $tipoPozo=Well::select('pet')->where(['id' => $this->wellcontrol->well_id])->first();
        if($tipoPozo->pet =="PET" && $this->wellcontrol->prod_bruta_mt3==0){
            session()->flash('msg-error','Favor verifique datos');
            return;
        }
        if($tipoPozo->pet =="GAS" && $this->wellcontrol->gas_neto_mt3==0){
            session()->flash('msg-error','Favor verifique datos');
            return;            
        }

        $brutamt3=round($this->wellcontrol->prod_bruta_mt3,2);
        $aguamt3=round(($brutamt3*$this->wellcontrol->agua_emul_por/100),2);
        $oilmt3=round(($brutamt3-$aguamt3),2);

        $bruta24=round(($this->wellcontrol->prod_bruta_mt3/$this->wellcontrol->horas*24),2);
        $agua24=round(($bruta24*$this->wellcontrol->agua_emul_por/100),2);

        if( ($bruta24-$agua24)!=0 && ($this->wellcontrol->gas_neto_mt3/$this->wellcontrol->horas*24)!=0){
            $gor=($this->wellcontrol->gas_neto_mt3/$this->wellcontrol->horas*24) / ($bruta24-$agua24);
         }else{
            $gor=0;  
         }
        
        Wellcontrol::query()
            ->where('id', $this->wellcontrolId)           
            ->update([
                "area_id" => 1,
                "well_id" => $this->wellcontrol->well_id,
                "fecha" => $this->wellcontrol->fecha,
                "horas" => $this->wellcontrol->horas,
                "agua_emul_por" => $this->wellcontrol->agua_emul_por,
                "prod_bruta_mt3" =>$brutamt3 ,
                "oil_neto_mt3" => $oilmt3,
                "agua_neto_mt3" =>$aguamt3,
                "gas_neto_mt3" => $this->wellcontrol->gas_neto_mt3,
                "gas_inyectado" => $this->wellcontrol->gas_inyectado,
                "gor" => $gor,
    
                "carrera" => $this->wellcontrol->carrera,
                "gpm" => $this->wellcontrol->gpm,
                "orificio" => $this->wellcontrol->orificio,
                "estado" => 'Modificado',

                "prod_bruta_24" => $bruta24,            
                "agua_neto_24" =>$agua24,
                "oil_neto_24" => round(($bruta24-$agua24),2),
                "gas_neto_24" => $this->wellcontrol->gas_neto_mt3/$this->wellcontrol->horas*24,                'created_at'=>now(),           
                "gor" =>  $this->wellcontrol->gor,
                'updated_at'=>now()            
    
            ]);
         
        $this->emit('saved');
        $this->reset('wellcontrol');
        return redirect()->to('/wellcontrol');

    }

    public function mount ()
    {
        if (!$this->wellcontrol && $this->wellcontrolId) {
            $this->wellcontrol = WellControl::find($this->wellcontrolId);   
        }else{
            $this->wellcontrol = new WellControl;
            $this->wellcontrol->agua_neto_mt3=0;
            $this->wellcontrol->oil_neto_mt3=0;
            $this->wellcontrol->agua_neto_24=0;
            $this->wellcontrol->oil_neto_24=0;
            $this->wellcontrol->gas_neto_24=0;
            $this->wellcontrol->prod_bruta_24=0;
            $this->wellcontrol->gas_inyectado=0;
            $this->wellcontrol->gor=0;
            $this->wellcontrol->area_id=1; 
            $carbon = new \Carbon\Carbon();
            $this->fechaHoy= $carbon->now();
            $date=date_create($this->fechaHoy);           
            date_add($date,date_interval_create_from_date_string("-1 days"));     
            $this->wellcontrol->fecha=date_format($date,"d-m-Y");
            $this->primerDia=(new DateTime($this->wellcontrol->fecha))->modify('first day of this month')->format('d-m-Y');;

        }
        $this->button = create_button($this->action, "wellcontrol");
    }

    public function render()
    {
        $this->wells = Well::select('*')->where( ['well_state_id' => 8, 'area_id' => 1])->get();       
        return view('livewire.well-control-create',[
            'wells' => $this->wells,
            ]);
    }


    public function CalcularVol($aguaP, $prodBruta){

         $aguaP=$this->wellcontrol->agua_emul_por;
         $prodBruta=$this->wellcontrol->prod_bruta_m3;
         $this->wellcontrol->agua_neto_mt3=round(floatval($prodBruta*$aguaP/100),4);
         $this->wellcontrol->oil_neto_mt3=round( floatval($prodBruta-$this->wellcontrol->agua_neto_mt3),4);
          
    }
  
}
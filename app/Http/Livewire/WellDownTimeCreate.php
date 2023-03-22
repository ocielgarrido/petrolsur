<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Well;
use App\Models\WellCause;
use App\Models\WellControl;
use App\Models\WellDownTime;
use Carbon\Carbon;
use DateTime;

class WellDownTimeCreate extends Component
{
    public $listeners = ['getDataControl'];
    public $welldowntime;
    public $wellcause;
    public $welldowntimeId, $primerDia;
    public $wellcontrol;
    public $well;
    public $action;
    public $button;
    protected function getRules(){   
        if( $this->action == "updateWelldowntime"){
            $rules = [
                'welldowntime.fecha' => 'required|min:10|max:10|unique:well_down_times,fecha,' .$this->welldowntimeId,
            ];
        }else{
            $rules = [
                'welldowntime.fecha' => 'required|min:10|max:10|unique:well_down_times,fecha,well_id',
  
            ];

        }
        return array_merge([
            'welldowntime.area_id' => 'required',
            'welldowntime.well_id' => 'required',
            'welldowntime.horas' => 'required',
            'welldowntime.well_cause_id' => 'required',
            'welldowntime.agua_perdido_mt3' => 'required',
            'welldowntime.oil_perdido_mt3' => 'required',
            'welldowntime.gas_perdido_mt3' => 'required',
            'welldowntime.obs' => 'nullable',

        ], $rules);

    }


    public function createWellDownTime(){
        $this->resetErrorBag();
        $this->validate();    
        $results=array(
            "area_id" => 1,
            "well_id"=> $this->welldowntime->well_id,
            "fecha" => $this->welldowntime->fecha->format('Y-m-d'),
            "horas" => $this->welldowntime->horas,
            "well_cause_id" => $this->welldowntime->well_cause_id,
            "agua_perdido_mt3" => $this->welldowntime->agua_perdido_mt3,
            "oil_perdido_mt3" => $this->welldowntime->oil_perdido_mt3,
            "gas_perdido_mt3" => $this->welldowntime->gas_perdido_mt3,
            "obs" => $this->welldowntime->obs,
            "estado" => 'Creado',
            'updated_at'=>now(),    
            'created_at'=>now()    
              
        );
        WellDownTime::insert($results);
   
        $this->emit('saved');
        $this->reset('welldowntime');
        return redirect()->to('/welldowntime');

    }

    public function updateWellDownTime() {
        $this->resetErrorBag();
        $this->validate();

        WellDownTime::query()
            ->where('id', $this->welldowntimeId)           
            ->update([
                "area_id" => 1,
                "well_id"=> $this->welldowntime->well_id,
                "fecha" => $this->welldowntime->fecha->format('Y-m-d'),
                "horas" => $this->welldowntime->horas,
                "well_cause_id" => $this->welldowntime->well_cause_id,
                "agua_perdido_mt3" => $this->welldowntime->agua_perdido_mt3,
                "oil_perdido_mt3" => $this->welldowntime->oil_perdido_mt3,
                "gas_perdido_mt3" => $this->welldowntime->gas_perdido_mt3,
                "obs" => $this->welldowntime->obs,
                "estado" => 'Modificado',
                'updated_at'=>now(),    
     
            ]);
         
        $this->emit('saved');
        $this->reset('welldowntime');
        return redirect()->to('/welldowntime');

    }

    public function mount ()
    {
        if (!$this->welldowntime && $this->welldowntimeId) {
            $this->welldowntime = WellDownTime::find($this->welldowntimeId);
        }else{
            $this->welldowntime = new WellDownTime;
            $fecha_hoy= now()->format('Y-m-d');
            $date=date_create($fecha_hoy);           
            date_add($date,date_interval_create_from_date_string("-1 days"));     
            $this->welldowntime->fecha=date_format($date,"d-m-Y");
            $this->primerDia=(new DateTime($this->welldowntime->fecha))->modify('first day of this month')->format('d-m-Y');;

        }

        $this->button = create_button($this->action, "Welldowntime");
    }

  
    public function getDataControl(){
  
        $this->wellcontrol= WellControl::latest('created_at')->where(['well_id' =>$this->welldowntime->well_id])->first();
        if(is_null($this->wellcontrol)){
            $this->emit('Debe cargar un control de pozo previamente');
            $horasparo=$this->welldowntime->horas;    
            $bruta=0;
            $oil=0;
            $agua=0;
            $gas=0;
            $this->welldowntime->oil_perdido_mt3=round(floatval($oil/24)*$horasparo,3);
            $this->welldowntime->agua_perdido_mt3=round(floatval($agua/24)*$horasparo,3);
            $this->welldowntime->gas_perdido_mt3=round(floatval($gas/24)*$horasparo,3);

        }else{
            $horasparo=$this->welldowntime->horas;    
            $bruta=$this->wellcontrol->prod_bruta_m3;
            $oil=$this->wellcontrol->oil_neto_mt3;
            $agua=$this->wellcontrol->agua_neto_mt3;
            $gas=$this->wellcontrol->gas_neto_mt3;
            $this->welldowntime->oil_perdido_mt3=round(floatval($oil/24)*$horasparo,3);
            $this->welldowntime->agua_perdido_mt3=round(floatval($agua/24)*$horasparo,3);
            $this->welldowntime->gas_perdido_mt3=round(floatval($gas/24)*$horasparo,3);
        }
 
    }
    public function render()
    {

        $this->wells=Well::select('id','pozo')->orderBy('pozo')->where([ 'well_state_id' =>8])->get();
        $this->wellcauses=WellCause::select('id','causa')->orderBy('causa')->get();
        return view('livewire.well-down-time-create',[
            'wells' => $this->wells,
            'wellcauses' =>$this->wellcauses
            ]);
    }
}

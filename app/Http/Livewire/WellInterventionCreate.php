<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Well;
use App\Models\WellIntervention;
use Carbon\Carbon;
use DateTime;

class WellInterventionCreate extends Component
{
    public $well; 
    public $wellintervention;
    public $wellinterventionId;
    public $action;
    public $button;
    public $fechaHoy,$primerDia;
 
    protected function getRules(){   
        if( $this->action == "updateWellIntervention"){
            $rules = [
                'wellintervention.fecha' => 'required|date|unique:well_interventions,fecha,' .$this->wellinterventionId,
            ];
        }else{
            $rules = [
                'wellintervention.fecha' => 'required|date|unique:well_interventions,fecha',
            ];

        }
        return array_merge([
            'wellintervention.area_id' => 'required',
            'wellintervention.well_id' => 'required',
            'wellintervention.motivo' => 'required',
            'wellintervention.obs' => 'nullable',
  
        ], $rules);

    }

    public function createWellIntervention(){
        $this->resetErrorBag();
        $this->validate();    

        WellIntervention::create(
            [
                'area_id' => 1,
                'well_id' => $this->wellintervention->well_id,
                'fecha' => $this->wellintervention->fecha,
                'motivo' => $this->wellintervention->motivo,
                'obs' => $this->wellintervention->obs,
                "estado" => 'Creado',
                 
            ]
        );

        $this->emit('saved');
        $this->reset('wellintervention');
        return redirect()->to('/wellintervention');

    }

    public function updateWellIntervention() {
        $this->resetErrorBag();
        $this->validate();
        WellIntervention::query()
            ->where('id', $this->wellinterventionId)           
            ->update([
                "area_id" => 1,
                'well_id' => $this->wellintervention->well_id,
                'fecha' => $this->wellintervention->fecha,
                'motivo' => $this->wellintervention->motivo,
                'obs' => $this->wellintervention->obs, 
                "estado" => 'Modificado',
  
            ]);
         
        return redirect()->to('/wellintervention');

    }

    public function mount ()
    {
         if (!$this->wellintervention && $this->wellinterventionId) {
      
            $this->wellintervention = WellIntervention::find($this->wellinterventionId);   
            $this->wellintervention->area_id=1; 
        }else{
            $this->wellintervention = new WellIntervention; 
            $carbon = new \Carbon\Carbon();
            $this->wellintervention->fecha= $carbon->now();
            $date=date_create($this->wellintervention->fecha);           
            date_add($date,date_interval_create_from_date_string("-1 days"));     
            $this->wellintervention->area_id=1;
            $this->wellintervention->fecha=date_format($date,"d-m-Y");
            $this->primerDia=(new DateTime($this->wellintervention->fecha))->modify('first day of this month')->format('d-m-Y');;

        }
           $this->button = create_button($this->action, "WellIntervention");
    }
   
    public function render()
    {
        $this->wells = Well::select('*')->where( ['well_state_id' => 8, 'area_id' => 1])->get();
 
        return view('livewire.well-intervention-create',[
            'wells' => $this->wells,
        ]);
    }
}

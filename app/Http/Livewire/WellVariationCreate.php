<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WellVariation;
use Carbon\Carbon;
use DateTime;


class WellVariationCreate extends Component
{

    public $wellvariation;
    public $wellvariationId;
    public $action;
    public $button;
    public $fechaHoy,$primerDia;
 
    protected function getRules(){   
        if( $this->action == "updateWellVariation"){
            $rules = [
                'wellvariation.fecha' => 'required|date|unique:well_variations,fecha,' .$this->wellvariationId,
            ];
        }else{
            $rules = [
                'wellvariation.fecha' => 'required|date|unique:well_variations,fecha',
            ];

        }
        return array_merge([
            'wellvariation.area_id' => 'required',
            'wellvariation.mt3' => 'required',
            'wellvariation.obs' => 'required',
  
        ], $rules);

    }


    public function createWellVariation(){
        $this->resetErrorBag();
        $this->validate();    

        WellVariation::create(
            [
                'area_id' => 1,
                'fecha' => $this->wellvariation->fecha,
                'mt3' => $this->wellvariation->mt3,
                'obs' => $this->wellvariation->obs,
                "estado" => 'Creado',
                 
            ]
        );

        $this->emit('saved');
        $this->reset('wellvariation');
        return redirect()->to('/variation');

    }

    public function updateWellVariation() {
        $this->resetErrorBag();
        $this->validate();
        WellVariation::query()
            ->where('id', $this->wellvariationId)           
            ->update([
                "area_id" => 1,
                'fecha' => $this->wellvariation->fecha,
                'mt3' => $this->wellvariation->mt3,
                'obs' => $this->wellvariation->obs, 
                "estado" => 'Modificado',
  
            ]);
         
        return redirect()->to('/variation');

    }

    public function mount ()
    {
       
        if (!$this->wellvariation && $this->wellvariationId) {
      
            $this->wellvariation = WellVariation::find($this->wellvariationId);   
            $this->wellvariation->area_id=1; 
            $this->primerDia=$this->wellvariation->fecha;
        }else{
            $this->wellvariation = new WellVariation; 
            $carbon = new \Carbon\Carbon();
            $this->wellvariation->fecha= $carbon->now();
            $date=date_create($this->wellvariation->fecha);           
            date_add($date,date_interval_create_from_date_string("-1 days"));     
            $this->wellvariation->area_id=1;
            $this->wellvariation->fecha=date_format($date,"d-m-Y");
            $this->primerDia=(new DateTime($this->wellvariation->fecha))->modify('first day of this month')->format('d-m-Y');;

        }
           $this->button = create_button($this->action, "WellVariation");
    }

    public function render()
    {
        return view('livewire.well-variation-create');
    }
}

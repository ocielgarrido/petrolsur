<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tank;
use App\Models\TankControl;
use DateTime;

class TankControlCreate extends Component
{
    public $tankcontrol;
    public $tankcontrolId;
    public $tank;
    public $tanks;
    public $action;
    public $button;
    public $fechaHoy,$primerDia;

    protected function getRules(){   
        if( $this->action == "updateTankControl"){
            $rules = [
                'tankcontrol.fecha' => 'required|min:10|max:100|unique:tank_controls,fecha,' .$this->tankcontrolId,
            ];
        }else{
            $rules = [
                'tankcontrol.fecha' => 'required|min:10|max:10|unique:tank_controls,fecha',
            ];

        }
        return array_merge([
            'tankcontrol.area_id' => 'required',
            'tankcontrol.tank_id' => 'required',
            'tankcontrol.agua'   => 'required|min:0|max:100|',
            'tankcontrol.sales' => 'required',
            'tankcontrol.temp' => 'required|int',
            'tankcontrol.densidad' => 'required',
             
   
        ], $rules);

    }

    public function mount ()
    {
  
        if (!$this->tankcontrol && $this->tankcontrolId) {
            $this->tankcontrol = TankControl::find($this->tankcontrolId);   
        }else{
            $this->tankcontrol = new TankControl;
             $this->tankcontrol->area_id=1; 
            $carbon = new \Carbon\Carbon();
            $this->fechaHoy= $carbon->now();
            $date=date_create($this->fechaHoy);           
            date_add($date,date_interval_create_from_date_string("-1 days"));     
            $this->tankcontrol->fecha=date_format($date,"d-m-Y");
            $this->primerDia=(new DateTime($this->tankcontrol->fecha))->modify('first day of this month')->format('d-m-Y');;

        }
        $this->button = create_button($this->action, "tankcontrol");
    }

    public function createTankControl(){
        $this->resetErrorBag();
        $this->validate();      

        $results=array(
            "area_id" => 1,
            "tank_id" => $this->tankcontrol->tank_id,
            "fecha" => $this->tankcontrol->fecha,
            "agua" => $this->tankcontrol->agua,
            "sales" => $this->tankcontrol->sales,
            "temp" => $this->tankcontrol->temp,
            "densidad" => $this->tankcontrol->densidad,
            "estado" => 'Creado',
            'updated_at'=>now(),
            'created_at'=>now(),    
              
        );
        TankControl::insert($results);    
        $this->emit('saved');
        return redirect()->to('/tankcontrol');

    }

    public function updateTankControl() {
        $this->resetErrorBag();
        $this->validate();
        
         
        Tankcontrol::query()
            ->where('id', $this->tankcontrolId)           
            ->update([
                "area_id" => 1,
                "tank_id" => $this->tankcontrol->tank_id,
                "fecha" => $this->tankcontrol->fecha,
                "agua" => $this->tankcontrol->agua,
                "sales" => $this->tankcontrol->sales,
                "temp" =>$this->tankcontrol->temp,
                "densidad" =>$this->tankcontrol->densidad,
                "estado" => 'Modificado',
                'updated_at'=>now()            
    
            ]);
         
        $this->emit('saved');
        $this->reset('tankcontrol');
        return redirect()->to('/tancontrol');

    }


    public function render()
    {

        $this->tanks = Tank::select('*')->where( ['estado' => 'activo', 'area_id' => 1])->get();       
        return view('livewire.tank-control-create',[
            'tanks' => $this->tanks,
        ]);
 
     
    }
}

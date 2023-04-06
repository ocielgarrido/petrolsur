<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Gasse;
use App\Models\WellControl;
use Carbon\Carbon;
use DateTime;
use Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

class GasseCreate extends Component
{
 
    public $gasse,$gasse_ant , $primerDia;
    public $gasseId;
    public $action;
    public $button;
 
    protected function getRules(){   
        if( $this->action == "updateGasse"){
            $rules = [
                'gasse.fecha' => 'required|min:10|max:10|unique:gasses,fecha,'.$this->gasseId,
             ];
        }else{
            $rules = [
                'gasse.fecha' => 'required|min:10|max:10|unique:gasses,fecha',
             ];

        }
        return array_merge([
            'gasse.area_id' => 'required',
            'gasse.pm10' =>  'required|integer|min:0|max:50000',
            'gasse.pm316' => 'required|integer|min:0|max:50000',
            'gasse.a9300' => 'required|integer|min:0|max:50000',
            'gasse.obs' => 'nullable',
 
        ], $rules);

    }


    public function createGasse(){
        $this->resetErrorBag();
        $this->validate();    

        Gasse::create(
            [
                'area_id' => 1,
                'client_id' => 1,
                'fecha' => $this->gasse->fecha,
                'pm10' => $this->gasse->pm10,
                'pm316' => $this->gasse->pm316,
                'a9300' => $this->gasse->a9300,
                'obs' => $this->gasse->obs,
                "estado" => 'Creado',
                
            ]
        );
        $this->emit('saved');
        $this->reset('gasse');
        return redirect()->to('/gasse');
    }

    public function updateGasse() {
        $this->resetErrorBag();
        $this->validate();

        Gasse::query()
            ->where('id', $this->gasseId)           
            ->update([
                'area_id'=> $this->gasse->area_id,
                'client_id'=> 1,                
                "fecha" => $this->gasse->fecha,
                "pm10" => $this->gasse->pm10,
                "pm316" => $this->gasse->pm316,
                "a9300" => $this->gasse->a9300,
                "estado" => 'Modificado',
 
            ]);
         
        $this->emit('saved');
        $this->reset('gasse');
        return redirect()->to('/gasse');
 
    }

 
    public function mount ()
    {
         if (!$this->gasse && $this->gasseId) {
            $this->gasse = Gasse::find($this->gasseId);
            $this->gasse->fecha=$this->gasse->fecha->format('d-m-Y');
   
        }else{
            $this->gasse_ant= Gasse::latest('created_at')->where([ 'area_id' =>1])->first(); //obtengo último registro  
           
            if(is_null($this->gasse_ant)){ 
                $this->gasse = new gasse;
                $carbon = new \Carbon\Carbon();
                $this->gasse->fecha= $carbon->now();
                $date=date_create($this->gasse->fecha);      
                date_add($date,date_interval_create_from_date_string("-1 days"));  
                $this->gasse->fecha=date_format($date,"d-m-Y");
             //   $this->primerDia=$this->gasse_ant->fecha;
               
                $this->gasse->area_id=1;
            }else{
                $this->gasse=$this->gasse_ant;
                $this->gasse->fecha= $this->gasse_ant->fecha;
                $date=date_create($this->gasse->fecha);           
                date_add($date,date_interval_create_from_date_string("1 days")); 
                $this->gasse->fecha=date_format($date,"d-m-Y");          
                $this->primerDia=$this->gasse_ant->fecha;
                $this->primerDia=date_format($this->primerDia,"d-m-Y");
                $this->gasse->area_id=1;    
                $this->gasse->pm10=0;    
                $this->gasse->pm316=0;    
                $this->gasse->a9300=0;   
                $this->gasse->obs='';    
   
                
            }
    }
        

        $this->button = create_button($this->action, "Gasse");
    }

    public function render()
    {
      
        return view('livewire.gasse-create');
    }

    
}
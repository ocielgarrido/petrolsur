<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tank;
use App\Models\Well;
use App\Models\Client;
use App\Models\Movement;
use App\Models\Product;

class MovementCreate extends Component
{
    Public $area_id=1, $client_id, $tank_id;
    public $movement, $movement_ant ,$primerDia;
    public $movementId;
    public $action;
    public $button;
  
  
    public function createMovement ()
    {
        $this->resetErrorBag();
        $this->validate();
        Movement::create(
            [
                'area_id' => 1,
                'client_id' => $this->movement->client_id,
                'product_id' => $this->movement->product_id,
                'fecha' => $this->movement->fecha,
                'tipo' => $this->movement->tipo,                
                'remito' => $this->movement->remito,
                'torigen' => $this->movement->torigen,
                'tdestino' => $this->movement->tdestino,
                'tank_id_ori' => $this->movement->tank_id_ori,
                'well_id_ori' => $this->movement->well_id_ori,
                'tank_id_des' => $this->movement->tank_id_des,
                'well_id_des' => $this->movement->well_id_des,
                'volumen' => $this->movement->volumen,
                'obs' => $this->movement->obs,
                "estado" => 'Creado',
                
            ]
        );  
        $this->emit('saved');
        return redirect()->to('/movement');

    }
  

    public function updateMovement ()
    {
        $this->resetErrorBag();
        $this->validate();

        Movement::query()
            ->where('id', $this->movementId)
            ->update([
                'area_id' => 1,
                'client_id' => $this->movement->client_id,
                'product_id' => $this->movement->product_id,
                'fecha' => $this->movement->fecha,
                'tipo' => $this->movement->tipo,                
                'remito' => $this->movement->remito,
                'torigen' => $this->movement->torigen,
                'tdestino' => $this->movement->tdestino,
                'tank_id_ori' => $this->movement->tank_id_ori,
                'well_id_ori' => $this->movement->well_id_ori,
                'tank_id_des' => $this->movement->tank_id_des,
                'well_id_des' => $this->movement->well_id_des,
                'volumen' => $this->movement->volumen,
                'obs' => $this->movement->obs,
                "estado" => 'Modificado',
  
            ]);

        $this->emit('saved');
    }

    public function mount ()
    {
       
        if (!$this->movement && $this->movementId) {
            $this->movement = Movement::find($this->movementId);
        }else{
            $this->movement_ant= Movement::latest('fecha')->where([ 'area_id' =>1])->first(); 
         
            if(is_null($this->movement_ant)){ 
                $this->movement = new movement;
                $carbon = new \Carbon\Carbon();
                $this->movement->fecha= $carbon->now();
                $date=date_create($this->movement->fecha);      
                date_add($date,date_interval_create_from_date_string("-1 days"));  
                $this->movement->fecha=date_format($date,"d-m-Y");
                $this->primerDia=$this->movement->fecha;
               
            }else{    
                $this->primerDia=$this->movement_ant->fecha;
                $this->movement=new movement;
                $this->movement->fecha= $this->movement_ant->fecha;
                $date=date_create($this->movement->fecha);           
                date_add($date,date_interval_create_from_date_string("1 days")); 
                $this->movement->fecha=date_format($date,"d-m-Y");          
                $this->primerDia=$this->movement_ant->fecha;
                $this->primerDia=date_format($this->primerDia,"d-m-Y");
            }
        }


        $this->button = create_button($this->action, "Movement");
    }

    protected function getRules(){  
       
        if( $this->action == "updateMovement"){
            $rules = [
                'movement.fecha' => 'required|min:10|max:10|unique:movements,fecha,'.$this->movementId,
             ];       

        }elseif( $this->movement->tipo == 'mov_int' && $this->action != 'updateMovement'){
            $rules = [
                'movement.tipo' => 'required',
                'movement.fecha' => 'required|min:10|max:10',
                'movement.client_id' => 'nullable',
                'movement.product_id' => 'required',
                'movement.torigen' => 'required',
                'movement.tdestino' => 'required',
                'movement.tank_id_ori' => 'nullable',
                'movement.well_id_ori' => 'nullable',
                'movement.tank_id_des' => 'nullable',
                'movement.well_id_des' => 'nullable',
    
             ]; 
        }elseif ( $this->movement->tipo == 'mov_ext' && $this->action != 'updateMovement'){
            $rules = [
                'movement.tipo' => 'required',
                'movement.fecha' => 'required|min:10|max:10',
                'movement.client_id' => 'required',
                'movement.product_id' => 'required',
                'movement.torigen' => 'nullable',
                'movement.tdestino' => 'required',
                'movement.tank_id_ori' => 'nullable',
                'movement.well_id_ori' => 'nullable',
                'movement.tank_id_des' => 'nullable',
                'movement.well_id_des' => 'nullable',
    
             ]; 
        }else{
            $rules = [
                'movement.fecha' => 'required|min:10|max:10',
            ];           
        }

         return array_merge([
            'movement.tipo' => 'required',
            'movement.area_id' => 'required',
            'movement.remito' => 'required|min:3|max:14',
            'movement.volumen' => 'required',
            'movement.obs' => 'nullable',           
 
        ], $rules);
       
       
    }

    public function render()
        {

            $this->tanks = Tank::select('*')->where( ['estado' => 'Activo', 'area_id' => 1])->get();
            $this->wells = Well::select('*')->where( ['area_id' => 1])->get();
            $this->products = Product::select('*')->get();

            return view('livewire.movement-create',[
                'clients' => Client::all(),
                'tanks' => $this->tanks,
                'wells' => $this->wells,
                'products' => $this->products,
                
            ]);   
            
        }

   
}


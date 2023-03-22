<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tank;

class TankCreate extends Component
{
    public $tank;
    public $tankId;
    public $action;
    public $button;
 //   public $area_id=1; //$api,$cte,$nombre,$capacidad,$altura,$largo,$fabricacion,$interno,$estado;

    protected function getRules()
    {
        $rules = ($this->tank->api === 1) ? [
            'tank.cte' =>'required',
            
        ] : [
            'tank.altura' => 'required',
            'tank.largo' => 'required',
        ];


        return array_merge([
            'tank.nombre' => 'required|min:5|max:20|unique:tanks,nombre,'.$this->tankId,
            'tank.api' =>'required',
            'tank.cte' =>'required',
            'tank.capacidad' => 'required',
            'tank.interno' => 'required',
            'tank.estado' => 'required',
            'tank.fabricacion' => 'required',
            'tank.alturaT' => 'required',
     
        ], $rules);
    }

    public function createTank (){

            
        $this->resetErrorBag();

        Tank::create($this->tank);
    
        $this->emit('saved');
        $this->reset('tank');
    }

    public function updateTank ()
    {
        $this->resetErrorBag();
        $this->validate();

        Tank::query()
            ->where('id', $this->tankId)
            ->update([
                'area_id' =>$this->tank->area_id,
                "nombre" => $this->tank->nombre,
                "capacidad" => $this->tank->capacidad,
                "api" => $this->tank->api,
                "cte" => $this->tank->cte,
                "altura" => $this->tank->altura,
                "interno" => $this->tank->interno,
                "estado" => $this->tank->estado,
                "fabricacion" => $this->tank->fabricacion,
                "alturaT" => $this->tank->alturaT,
                "obs" => $this->tank->obs,
            ]);

        $this->emit('saved');
        return redirect()->to('/tank');

        
    }

    public function mount ()
    {
        if (!$this->tank && $this->tankId) {
            $this->tank = Tank::find($this->tankId);
        }

        $this->button = create_button($this->action, "Tank");
    }

    public function render()
    {
        return view('livewire.tank-create');
    }

  
}

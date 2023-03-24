<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\GasseConsumo;
class GasseconsumoComponent extends Component
{
    public $consumo;
    public $consumoId;
    public $action;
    public $button;
  
    public function mount () {
         if (!$this->consumo && $this->consumoId) {
            $this->consumo = GasseConsumo::find($this->consumoId);
   
        }else{
            $this->consumo= new GasseConsumo;
           
        }
        $this->button = create_button($this->action, "Consumo");
    }
        
   
    public function render()
    {
        return view('livewire.gasseconsumo-component');
    }
}

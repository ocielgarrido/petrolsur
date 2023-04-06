<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Well;
use App\Models\WellState;
use App\Models\WellFormation;     
use App\Models\Yacimiento;    
    class WellCreate extends Component

    {
        public $states, $state_id;
        public $formations,$formation_id;
        public $well;
        public $wellId;
        public $yacimientos;
        public $action;
        public $button;
    
     
    
        public function createWell(){
    
                
            $this->resetErrorBag();
    
            Well::create($this->well);
        
            $this->emit('saved');
            $this->reset('well');
        }
    
        public function updateWell()
        {
            $this->resetErrorBag();
           $this->validate();
    
            Well::query()
                ->where('id', $this->wellId)
                ->update([
                    'area_id' =>$this->well->area_id,
                    'yacimiento_id' =>$this->well->yacimiento_id,
                    "pozo" => $this->well->pozo,
                    "well_formation_id" => $this->well->well_formation_id,
                    "cap_iv_nombre" => $this->well->cap_iv_nombre,
                    "latitud" => $this->well->latitud,
                    "longitud" => $this->well->longitud,
                    "cord_x" => $this->well->cord_x,
                    "cord_y" => $this->well->cord_x,
                    "profundidad" => $this->well->profundidad,
                    "perfo_ini" => $this->well->perfo_ini,
                    "perfo_fin" => $this->well->perfo_fin,
                    "termi_ini" => $this->well->termi_ini,
                    "termi_fin" => $this->well->termi_fin,
                    "well_state_id"  => $this->well->well_state_id,
                    "cota" => $this->well->cota,
                    "prod_oil_dic" => $this->well->prod_oil_dic,
                    "prod_gas_dic" => $this->well->prod_gas_dic,
                    "prod_agua_dic" => $this->well->prod_agua_dic,
                    "iny_agua_dic" => $this->well->iny_agua_dic,
                    "iny_gas_dic" => $this->well->iny_gas_dic,
                    "iny_co_dic" => $this->well->iny_co_dic,
                    "iny_otr_dic" => $this->well->iny_otr_dic,
                    "vida_util_dic" => $this->well->vida_util_dic,
                    "abandono" => $this->well->abandono,
                    "tipo" => $this->well->tipo,
                    "capacidad" => $this->well->capacidad,
                    "idpozo" => $this->well->idpozo,
                    'arap' => $this->well->arap,
                    "updated_at" =>now(),
            
               
                ]);
    
            $this->emit('saved');
            return redirect()->to('/well');

    
            
        }
    
        public function mount ()
        {
            if (!$this->well && $this->wellId) {
                 $this->well = Well::find($this->wellId);
            }else{
                $this->well = new Well;
            }
    
            $this->button = create_button($this->action, "Well");


          
        }
    
        public function render()
        {
            $this->states=WellState::all();
            $this->formations = WellFormation::all();      
            $this->yacimientos=Yacimiento::all();
            return view('livewire.well-create',[
                'states' => $this->states,
                'formations' => $this->formations,
                'yacimientos' => $this->yacimientos
                ]);
        }
    
        protected function getRules(){   
            if( $this->action == "updateWell"){
                $rules = [
                    'well.pozo' => 'required|min:5|max:20|unique:wells,pozo,' .$this->wellId,
                    'well.cap_iv_nombre' => 'required|min:5|max:30|unique:wells,cap_iv_nombre,' .$this->wellId,
                    'well.yacimiento_id' => 'required',
                ];
            }else{
                $rules = [
                    'well.pozo' => 'required|min:5|max:20|unique:well,nombre',
                    'well.cap_iv_nombre' => 'required|min:5|max:30|unique:well,nombre',
                    'well.yacimiento_id' => 'required',
                ];
    
            }
            return array_merge([
                'well.area_id' => 'required',    
                'well.well_formation_id' => 'required',                               
                'well.latitud' => 'nullable',                               
                'well.longitud' => 'nullable',                               
                'well.cord_x' => 'required',
                'well.cord_y' => 'required',
                'well.profundidad' => 'required',
                'well.perfo_ini' => 'nullable',
                'well.perfo_fin' => 'nullable',
                'well.termi_ini' => 'nullable',
                'well.termi_fin' => 'nullable',
                'well.well_state_id' => 'required',
                'well.cota' => 'required',
                'well.idpozo' =>'required',
                'well.prod_oil_dic' => 'required',
                'well.prod_gas_dic' => 'required',
                'well.prod_agua_dic' => 'required',
                'well.iny_agua_dic' => 'required',
                'well.iny_gas_dic' => 'required',
                'well.iny_co_dic' => 'required',
                'well.iny_otr_dic' => 'required',
                'well.vida_util_dic' => 'required',
                'well.abandono' => 'nullable',
                'well.tipo' => 'required',
                'well.capacidad' => 'required',
                'well.arap' => 'required',
        

      
            ], $rules);
    
        }
      
    }
    
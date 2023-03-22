<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Compressor;
use App\Models\CompressorCause;
use App\Models\CompressorDownTime;
use Carbon\Carbon;
use DateTime;

class CompressorDownTimeCreate extends Component
{
    public $compressordowntime;
    public $compressorcause;
    public $compressordowntimeId, $primerDia;
    public $compressor;
    public $action;
    public $button;
    protected function getRules(){   
        if( $this->action == "updateCompressorDownTime"){
            $rules = [
                'compressordowntime.fecha' => 'required|min:10|max:100|unique:compressor_down_times,fecha,' .$this->compressordowntimeId,
            ];
        }else{
            $rules = [
                'compressordowntime.fecha' => 'required|min:10|max:10|unique:compressor_down_times,fecha',
            ];

        }
        return array_merge([
            'compressordowntime.compressor_id' => 'required',
            'compressordowntime.horas' => 'required',
            'compressordowntime.compressor_causes_id' => 'required',                              
            'compressordowntime.horas_paro_msa' => 'required',
            'compressordowntime.obs' => 'required',
  
        ], $rules);

    }


    public function createCompressorDownTime(){
        $this->resetErrorBag();
       
        $this->validate();    

      //  CompressorDownTime::create($this->compressordowntime);

        $results=array(
            "compressor_id" => $this->compressordowntime->compressor_id,
            "fecha" => $this->compressordowntime->fecha->format('Y-m-d'),
            "horas" => $this->compressordowntime->horas,
            "compressor_causes_id" => $this->compressordowntime->compressor_causes_id,
            "horas_paro_msa" => $this->compressordowntime->horas_paro_msa,
            "horas_standby" => $this->compressordowntime->horas_standby,
            "obs" => $this->compressordowntime->obs,
            "estado" =>'Creado',
            'updated_at'=>now(),    
            'created_at'=>now()    
              
        );
      
        CompressorDownTime::insert($results);

        $this->emit('saved');
        $this->reset('compressordowntime');
        return redirect()->to('/compressor/downtime');

    }

    public function updateCompressorDownTime() {
        $this->resetErrorBag();

        $this->validate();

        CompressorDownTime::query()
            ->where('id', $this->compressordowntimeId)           
            ->update([
                "compressor_id" => $this->compressordowntime->compressor_id,
                "fecha" => $this->compressordowntime->fecha->format('Y-m-d'),
                "horas" => $this->compressordowntime->horas,
                "compressor_causes_id" => $this->compressordowntime->compressor_causes_id,
                "horas_paro_msa" => $this->compressordowntime->horas_paro_msa,
                "horas_standby" => $this->compressordowntime->horas_standby,
                "obs" => $this->compressordowntime->obs,
                "estado" =>'Modificado',
                'updated_at'=>now(),    
     
            ]);
         
        $this->emit('saved');
        $this->reset('compressordowntime');
        return redirect()->to('/compressor/downtime');

    }

    public function mount ()
    {
        if (!$this->compressordowntime && $this->compressordowntimeId) {
            $this->compressordowntime = compressordowntime::find($this->compressordowntimeId);
        }else{
            $this->compressordowntime = new CompressorDownTime;
            $fecha_hoy= now()->format('Y-m-d');
            $date=date_create($fecha_hoy);           
            date_add($date,date_interval_create_from_date_string("-1 days"));     
            $this->compressordowntime->fecha=date_format($date,"d-m-Y");
            $this->primerDia=(new DateTime($this->compressordowntime->fecha))->modify('first day of this month')->format('d-m-Y');;

        }

        $this->button = create_button($this->action, "compressordowntime");
    }

  

    public function render()
    {

        $this->compressor=Compressor::all();
        $this->compressorcauses=CompressorCause::select('id','codigo','causa')->orderBy('causa')->get();

        return view('livewire.compressor-down-time-create',[
            'compressors' => $this->compressor,
            'compressorcauses' =>$this->compressorcauses
            ]);
    }
 
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Models\Oil;
use App\Models\Tank;
use App\Models\OilDetail;
use App\Models\Htablet;
use App\Models\TankControl;
use Carbon\Carbon;
use DateTime;

class OilDetailCreate extends Component
{
    Public $pi=3.141592653;
    protected $listeners=['update'];

    //Componente
    public $showData = true;
    public $updateData = false;

     //Modelo
     public $oil, $oil_ant;
     public $oildetail;
     public $tank;
     public $fecha, $fechaAnt;
     
     Public $oilID;

    //actualizar
    public $oil_id;
    public $edit_id;
    public $altura;  
    public $corte_agua;  
    public $vOil, $vAgua,$vTotal; //calculados
    Public $tanque; //Nombre Tanqye
    Public $tank_id;

     public function mount ()
     {
        
         $this->oil_id =$this->oilID;
         $this->oil =Oil::findOrFail($this->oilID);
         $this->fecha=$this->oil->fecha;
         $date=date_create($this->fecha);           
         date_add($date,date_interval_create_from_date_string("-1 days"));                          
         $this->fechaAnt=date_format($date,"Y-m-d");
      
     }
     public function showForm()
     {
         $this->updateData = false;
         $this->showData = true;
     }

     public function edit($id)
     {
         $this->showData = false;
         $this->updateData = true;
         $oildetail = OilDetail::findOrFail($id); 
         $this->edit_id= $oildetail->id; 
         $this->tank_id= $oildetail->tank_id;       
         $this->altura = $oildetail->altura;
         $this->corte_agua = $oildetail->corte_agua;
         $this->vOil = $oildetail->oil;
         $this->vOil_des = $oildetail->oil_des;
         $this->vAgua = $oildetail->agua;
         $this->vTotal = $oildetail->total;
         $this->tanque=$oildetail->tank->nombre;
        }
 
     public function update($id)
     {
     
         $oildetail =OilDetail::findOrFail($id);
         $this->validate([
             'altura' => 'required',
             'corte_agua' => 'required',
  
         ]); 
         $oildetail->id=$this->edit_id;
         $oildetail->tank_id = $this->tank_id;
         $oildetail->altura = $this->altura;
         $oildetail->corte_agua = $this->corte_agua;
         $oildetail->oil = $this->vOil;
         $oildetail->oil_des = $this->vOil_des;
         $oildetail->agua = $this->vAgua;
         $oildetail->total = $this->vTotal;

         $result = $oildetail->save();

         $ventas = DB::table('sales')->where( ['fecha' => $this->fecha, 'area_id' =>1])->get()->sum('total');
         $ventas = $ventas ??  0;        
         $this->oil_ant= Oil::where([ 'fecha' =>$this->fechaAnt])->first(); //obtengo último registro
         $total_oil_ant=$this->oil_ant->oil_des; 
         $total_oil_dia= OilDetail::where('oil_id', $this->oilID)->get()->sum('oil_des');
         Oil::query()
         ->where('id', $this->oilID)           
         ->update([
             "agua" =>  OilDetail::where('oil_id', $this->oilID)->get()->sum('agua'),
             "oil" => OilDetail::where('oil_id', $this->oilID)->get()->sum('oil'),
             "oil_des" =>OilDetail::where('oil_id', $this->oilID)->get()->sum('oil_des'),
             "total" => OilDetail::where('oil_id', $this->oilID)->get()->sum('total'),
             "oil_production" => $total_oil_dia-($total_oil_ant - round(floatval($ventas),2)),
             "estado" => 'Modificado',

         ]);
         

         if ($result) {
             session()->flash('success', 'Medición actualizada correctamente!!');
             $this->showData = true;
             $this->updateData = false;
         } else {
             session()->flash('error', 'No se pudo actualizar Medición.');
         }
     }
     
     public function Recalcular(){
        $tank=Tank::find($this->tank_id);  
        $tankControl=TankControl::where(['tank_id' => $this->tank_id])->orderBy('created_at', 'desc')->first();  
      
        if ($this->altura > ($tank->alturaT*100)){
            session()->flash('msg-error','La altura ingresada no puede superar altura total Tanque ' . $this->tanque .'.');

        }else{             
   
            if($tank->api==1){
                $this->vAgua=round((floatval($this->corte_agua) * floatval($tank->cte)),2);
                $this->vOil=round((floatval($this->altura) - floatval($this->corte_agua)) * floatval($tank->cte),2);
                $this->vOil_des=round($this->vOil-($this->vOil*floatval($tankControl->agua)/100),2); // 
                $this->vTotal=round((floatval($this->vAgua)+floatval( $this->vOil)),2);                  

            }else{
                // calculo no api segun tabla 
                $H= floatval($tank->altura);  //en mts
                $L= floatval($tank->largo);   //en mts
                $volTotal=round(floatval(($this->pi*($H*$H)/4)*$L), 2); //en litros
                $hTotal=(floatval($this->altura) /100); //paso altura a cms
                $hAgua=(floatval($this->corte_agua) /100); //corte agua a cms.
                $fhTotal=round(($hTotal/$H),2); //obtengo FH total
                $fhAgua=round(($hAgua/$H),2);  //obtengo FH agua
                //calculo total de liquido           
                $tabla=Htablet::select("fv")->where("fh","=",$fhTotal)->first();
                $fvTotal=floatval($tabla->fv);
                $volumen=round(($volTotal*$fvTotal),3);
                //Calculo total Agua 
                $tabla=Htablet::where("fh","=",$fhAgua)->first();                
                $fvAgua=$tabla->fv;               
                $agua=round(($volTotal*$fvAgua),2);
                //Total Oil
                $oil=$volumen-$agua;
                $this->vAgua=round( $agua,2);
                $this->vOil=round($oil,2);
                $this->vOil_des=$this->vOil-($this->vOil*floatval($tankControl->agua)/100);
                $this->vTotal=round(($agua+$oil),2);                  

            } 
        } 
  
     }

    public function render()
    {
        $tanks =  Tank::select('*')->where( ['estado' => 'Activo', 'area_id' => 1])->get();
        $oildetails = OilDetail::select('*')->where( ['oil_id' =>  $this->oilID])->get();

        return view('livewire.oil-detail-create',[
            'tanks' => $tanks,
            'oildetails' => $oildetails
        ]);
    }
}

<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithDataTable;
use App\Models\Oil;
use App\Models\Sale;
use App\Models\Movement;
use App\Models\Tank;
use App\Models\OilDetail;
use App\Models\Htablet;
use App\Models\TankControl;

class Main extends Component
{
    use WithPagination, WithDataTable;

    public $model;
    public $name;

    public $perPage = 30;
    public $sortField = "id";
    public $sortAsc = false;
    public $search = '';

    protected $listeners = [ "deleteItem" => "delete_item","recalculaItem" =>"recalcula_item" ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }
    public function recalcula_item ($id)
    {
        $pi=3.141592653;
        $data = $this->model::find($id);
        $date=date_create($data->fecha);           
        date_add($date,date_interval_create_from_date_string("-1 days"));                          
        $fechaAnt=date_format($date,"Y-m-d");

        if (!$data) {
            $this->emit("recalculaResult", [
                "status" => false,
                "message" => "Ha ocurrido un error " . $this->name
            ]);
            return;
        }

        $oilDetails=OilDetail::where(['oil_id' => $id])->get();

        foreach($oilDetails as $oilDetail){
 
            $tank=Tank::find($oilDetail->tank_id);  
            $tankControl=TankControl::where(['tank_id' => $oilDetail->tank_id])->orderBy('created_at', 'desc')->first(); 
 
                if($tank->api==1){
                    $agua=round((floatval($oilDetail->corte_agua) * floatval($tank->cte)),2);
                    $oil=round((floatval($oilDetail->altura) - floatval($oilDetail->corte_agua)) * floatval($tank->cte),2);
                    $oil_des=round($oilDetail->oil-($oilDetail->oil*floatval($tankControl->agua)/100),2); 
                    $volumen=round((floatval($oilDetail->agua)+floatval( $oilDetail->oil)),2);
                }else{
                    $H= floatval($tank->altura);  //en mts
                    $L= floatval($tank->largo);   //en mts
                    $volTotal=round(floatval(($pi*($H*$H)/4)*$L), 2); //en litros
                    $hTotal=(floatval($oilDetail->altura) /100); //paso altura a cms
                    $hAgua=(floatval($oilDetail->corte_agua) /100); //corte agua a cms.
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
                    //Stock Total Oil H
                    $oil=$volumen-$agua;
                    //Stock Total Oil D.
                    $oil_des=round($oilDetail->oil-($oilDetail->oil*floatval($tankControl->agua)/100),2); 
                }
            $oilDetail->oil =$oil;
            $oilDetail->oil_des = $oil_des;
            $oilDetail->agua =$agua;
            $oilDetail->total = $volumen;  
            $oilDetail->save();       
        }  
        
        $ventasH = Sale::where( ['fecha' => $data->fecha, 'area_id' =>$data->area_id])->get()->sum('total');
        $ventasH = $ventasH ??  0;  
  
        $ventasD = Sale::where( ['fecha' => $data->fecha, 'area_id' =>$data->area_id])->get()->sum('total_des');
        $ventasD = $ventasD ??  0;  
 
        $movint= Movement::select('volumen')->where([ 'tipo'=>'mov_int','fecha' =>$data->fecha,'torigen'=>'T' ,'tdestino'=>'W'])->get()->sum('volumen');
        $movint = $movint ??  0;
        
        $movext= Movement::select('volumen')->where(['tipo'=>'mov_ext', 'fecha' =>$data->fecha,'tdestino'=>'T'])->get()->sum('volumen');        
        $movext = $movext ??  0;

        $stock_oilH_ant= Oil::where([ 'fecha' =>$fechaAnt])->get()->sum('stock_oil_h');
        $stock_oilH_dia= OilDetail::where('oil_id', $id)->get()->sum('oil');

        $stock_oilD_ant= Oil::where([ 'fecha' =>$fechaAnt])->get()->sum('stock_oil_d');        
        $stock_oilD_dia= OilDetail::where('oil_id', $id)->get()->sum('oil_des');

        $stock_agua_ant= Oil::where([ 'fecha' =>$fechaAnt])->get()->sum('stock_agua');
        $stock_agua_dia= OilDetail::where('oil_id', $id)->get()->sum('agua');

        $stock_total_ant=Oil::where([ 'fecha' =>$fechaAnt])->get()->sum('stock_total');
        $stock_total_dia=OilDetail::where('oil_id', $id)->get()->sum('total');
        
        $aray=array(
           'dia: ' => $data->fecha,
           'stock total dia' => $stock_total_dia,
           'stock total anterior' => $stock_total_ant,
           'stock oil Hid. dia' => OilDetail::where('oil_id', $id)->get()->sum('oil'),
           'Stock oil Hid. Ant.'=>$stock_oilH_ant,
           'stock oil Des. dia' => OilDetail::where('oil_id',$id)->get()->sum('oil_des'),
           'Stock oil Des. Ant.'=>$stock_oilD_ant,
           'stock Agua dia' => $stock_agua_dia,             
           'Tota Ventas Hid.' => $ventasH,
           'Tota Ventas Des.' => $ventasD,
           'Tota mov Int.' => $movint,
           'Tota Mov Ext ' => $movext ,
           'Prod Oil Hid. ' =>($stock_oilH_dia -$stock_oilH_ant+$ventasH-$movext) ,
           'Prod Oil Des. ' =>($stock_oilD_dia -$stock_oilD_ant+$ventasD-$movext) ,
           'Prod Agua ' =>(($stock_total_dia-$stock_total_ant+$ventasH+$movint-$movext)-($stock_oilH_dia -$stock_oilH_ant+$ventasH-$movext)) ,
           'Prod Bruta ' =>($stock_total_dia-$stock_total_ant+$ventasH+$movint-$movext),

        );
        //dd($aray);
        $data->stock_oil_h = OilDetail::where('oil_id', $id)->get()->sum('oil');
        $data->stock_oil_d =OilDetail::where('oil_id',$id)->get()->sum('oil_des');
        $data->stock_agua=  ($stock_agua_dia);
        $data->total_venta_h= $ventasH; 
        $data->total_venta_d= $ventasD; 
        $data->stock_total =$stock_total_dia;
        $data->prod_oil_h= ($stock_oilH_dia -$stock_oilH_ant+$ventasH-$movext); 
        $data->prod_oil_d= ($stock_oilD_dia -$stock_oilD_ant+$ventasD-$movext);          
        $data->prod_agua= (($stock_total_dia-$stock_total_ant+$ventasH+$movint-$movext)-($stock_oilH_dia -$stock_oilH_ant+$ventasH-$movext));          
        $data->prod_bruta  = ($stock_total_dia-$stock_total_ant+$ventasH+$movint-$movext) ; 
 
        $data->estado = 'Modificado';
        $data->updated_at = now();
        $data->save();

       
        $this->emit("recalculaResult", [
            "status" => true,
            "message" => "Registro " . $this->name . " Recalculado con éxito!"
        ]);
 
    }

    public function delete_item ($id)
    {
        $data = $this->model::find($id);
     
        if (!$data) {
            $this->emit("deleteResult", [
                "status" => false,
                "message" => "Ha ocurrido un error " . $this->name
            ]);
            return;
        }

        $data->delete();
        $this->emit("deleteResult", [
            "status" => true,
            "message" => "Registro " . $this->name . " Eliminado con éxito!"
        ]);
    }

    public function show_modal($id){
   
    }

    public function render()
    {
     
        $data = $this->get_pagination_data();        
        return view($data['view'], $data);
    }
}

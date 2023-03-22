<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Models\Oil;
use App\Models\OilDetail;
use App\Models\Tank;
use App\Models\Sale;
use App\Models\Movement;
use App\Models\TankControl;
use App\Models\Htablet;
use DateTime;

class OilCreate extends Component
{
    Public $pi=3.141592653;
    public $tanks, $tankId, $tankCount=0,$tankAdd=0,$primerDia;
    public $oilId,$altura, $corte_agua;
    public $oil,$oil_ant ,$fecha_anterior; //objeto anterior
    public $detailTank=[]; //listado de tanques con sus alturas y agua
    public $oildetails; 
    protected $listeners=['storeOilDetail'.'getDetailOil'];
    public $isDisabled=false;   
    public $isvisible=1;   
    public $action;
    public $button;
    
    

    public function render(){
       //Obtengo tanques a mostrar en vista 
        $this->tanks = Tank::select('*')->where( ['estado' => 'Activo', 'area_id' => 1])->get();
        return view('livewire.oil-create',[
        'tanks' =>$this->tanks                
        ]);
    }

    protected function getRules(){   
        if( $this->action == "updateOil"){
            $rules = [
                'oil.fecha' => 'required|min:10|max:10|unique:oil,fecha,' .$this->oilId,
            ];
        }else{
            $rules = [
                'oil.fecha' => 'required|min:10|max:100|unique:oil,fecha',
            ];

        }
        return array_merge([
            'oil.corte_agua' => 'required',
            'oil.altura' => 'required',
            'oil.tankId' => 'required',
  
        ], $rules);

    }
    public function resetInput(){
        $this->oil->tankId=0;
        $this->oil->altura=null;
        $this->oil->corte_agua=null;
    }
    
  
    public function removeItem($key){
        unset($this->detailTank[$key]);
        $this->tankAdd=$this->tankAdd-1;      
        session()->flash('msg-error','Se ha quitado el tanque, verifique');
  
    }
  

    public function mount (){
        if (!$this->oil && $this->oilId) {
           //editando
            $this->oil = new oil;
            $this->isvisible=0;
            $this->oil = Oil::find($this->oilId);
            $this->oil->fecha=$this->oil->fecha;
            $this->tankCount = OilDetail::select('*')->where( ['oil_id' => $this->oilId ])->count();            
            $this->tankAdd=$this->tankCount;
            $oilDetail = OilDetail::where('oil_id',$this->oilId)->get();           
            $this->setOilDetail($oilDetail);
           
        }else{
            //nuevo
             $this->oil_ant= Oil::latest('fecha')->where([ 'area_id' =>1])->first(); 
             $this->tankAdd=0;
             $this->tankCount = Tank::select('*')->where( ['estado' => 'Activo', 'area_id' => 1, ])->count();    
 
 
            if (is_null($this->oil_ant)){
                $this->oil = new oil;
                $carbon = new \Carbon\Carbon();
                $this->fecha= $carbon->now();
                $date=date_create($this->fecha);           
                date_add($date,date_interval_create_from_date_string("-1 days"));
                $this->oil->area_id=1;
                $this->oil->fecha=date_format($date,"d-m-Y");
                $this->primerDia=(new DateTime($this->oil->fecha))->modify('first day of this month')->format('d-m-Y');;
                $this->oil->area_id=1;
                $this->oildetails=[];
            }else{
                //dd('')
                $this->oil=$this->oil_ant;
                $carbon = new \Carbon\Carbon();
                $this->fecha= $this->oil_ant->fecha;               
                $date=date_create($this->fecha);           
                date_add($date,date_interval_create_from_date_string("+1 days"));                          
                $this->oil->fecha=date_format($date,"d-m-Y");                
                $this->fecha_anterior=date_format($this->oil_ant->fecha,"Y-m-d");  
                $this->primerDia=$this->oil_ant->fecha;                           
                $this->primerDia=date_format($this->primerDia,"d-m-Y");                   
                $this->oil->area_id=1;
                $this->oildetails=[];
                $this->tankCount = Tank::select('*')->where( ['estado' => 'Activo', 'area_id' => 1])->count();    
  
            }
        }
        $this->button = create_button('$this->action', "hidden");
    }
 
    public function setOilDetail($oilDetail){
        foreach ($oilDetail as $o) {          
           
            $detailTank =[
                'tank_Id'=> $o->tank_id,
                'nombre' => $o->Tank->nombre,
                'altura' => $o->altura,
                'corte_agua' =>$o->corte_agua,
                'agua' =>round($o->agua,2),
                'oil'  => round($o->oil,2),
                'oil_des'  => round($o->oil_des,2),
                'total'=> round($o->total,2)                
            ];  
            $this->detailTank[]= $detailTank;
        }

    }

    public function addDetalOil(){
       // dd($this->tankAdd . ' - ' .$this->tankCount);
        if($this->tankAdd==$this->tankCount){          
            session()->flash('msg-error','La cantidad de tanques medidos no coincide con tanques habilidados, por favor verifique');  
        }else{
            if($this->oil->tankId =='' || $this->oil->altura =='' || $this->oil->altura ==0 ||  $this->oil->corte_agua =='' ||  $this->oil->corte_agua ==0){
                session()->flash('msg-error','Debe completar todos los campos');
    
            }else{
            
                $tank=Tank::find($this->oil->tankId);
                $nombre= $tank->nombre;   
                $alturaT=$tank->alturaT*100;
                if ($alturaT<$this->oil->altura){
                    session()->flash('msg-error','La altura ingresada no puede superar altura total Tanque ' . $nombre .'.');

                }else{             
                    $tankControl=TankControl::where(['tank_id' => $this->oil->tankId])->orderBy('created_at', 'desc')->first();  

                    if($tank->api==1){
                    
                        $agua=floatval($this->oil->corte_agua) * floatval($tank->cte);
                        $oil=(floatval($this->oil->altura) - floatval($this->oil->corte_agua)) * floatval($tank->cte);
                        $oil_des=$oil-($oil*floatval($tankControl->agua)/100); 
                        $volumen=floatval($agua)+floatval($oil);                  
                    
                    }else{
                        // calculo no api segun tabla 
                        $H= floatval($tank->altura);  //en mts
                        $L= floatval($tank->largo);   //en mts
                        $volTotal=round(floatval(($this->pi*($H*$H)/4)*$L), 3); //en litros
                        $hTotal=(floatval($this->oil->altura) /100); //paso altura a cms
                        $hAgua=(floatval($this->oil->corte_agua) /100); //corte agua a cms.
                        $fhTotal=round(($hTotal/$H),2); //obtengo FH total
                        $fhAgua=round(($hAgua/$H),2);  //obtengo FH agua
                        //calculo total de liquido           
                        $tabla=Htablet::select("fv")->where("fh","=",$fhTotal)->first();
                        $fvTotal=floatval($tabla->fv);
                        $volumen=round(($volTotal*$fvTotal),3);
                        //Calculo total Agua 
                        $tabla=Htablet::where("fh","=",$fhAgua)->first();                
                        $fvAgua=$tabla->fv;               
                        $agua=round(($volTotal*$fvAgua),3);
                        //Total Oil
                        $oil=$volumen-$agua;
                        $oil_des=$oil-($oil*floatval($tankControl->agua)/100); // 

                    }      //fin calculo             
                
            
                $detailTank =array(
                    'tank_Id'=> $this->oil->tankId,
                    'nombre' => $nombre,
                    'altura' => $this->oil->altura,
                    'corte_agua' =>$this->oil->corte_agua,
                    'agua' =>round($agua,2),
                    'oil'  => round($oil,2),
                    'oil_des'  => round($oil_des,2),
                    'total'=> round($volumen,2)                
                );  
            
            
                //variale global
                $this->detailTank[]= $detailTank;
    
                session()->flash('message','Medidas calculadas con éxito');
                $this->resetInput();
                $this->tankAdd=$this->tankAdd+1;
            
    
            }
            }
        }
    }


    public function storeProduction(){    
       
         if($this->tankAdd<>$this->tankCount){
          
            session()->flash('msg-error','La cantidad de tanques medidos no coincide con tanques habilidados, por favor verifique');
  
        }else{
            
                $oilCount = DB::table('Oil')->where( ['fecha' =>  $this->oil->fecha, 'area_id' =>1])->count(); 
    
                if ($oilCount==0){                  
                   
                        $parte= Oil::create([
                            'area_id' => 1,
                            'fecha' => $this->oil->fecha,
                            'total_ventaH' =>0,
                            'total_ventaD' =>0,
                            'mov_int' =>0,
                            'mov_ext' =>0,
                            'prod_bruta' =>0,
                            'prod_oil_d' =>0,
                            'prod_oil_h' =>0,
                            'prod_agua' =>0,
                            'estado' => 'Creado'
                        ]);
                        
                        $this->oilId=$parte->id;    
                        $this->storeOilDetail();    
                      
                        session()->flash('message','Datos guardados con éxito');
                        return redirect()->to('/oil');
                    
                }else{
                    session()->flash('msg-error','Ya existe un parte para Area y Fecha seleccionada, por favor verifique');
                } 
            
      }
 
    }

    public function updateProduction(){           
        $this->storeOilDetail();
        Oil::query()        
        ->where('id', intval($this->oilId))
        ->update([
            "estado"  => 'Modificado',  
            "updated_at"=> now(), 

        ]);
    }

      public function storeOilDetail(){ 
        //DB::beginTransaction();
       // try{
            OilDetail::where('oil_id',$this->oilId)->delete();
            foreach ($this->detailTank as $key => $tank){
                $results=array(
                    "oil_id" => $this->oilId,
                    "tank_Id"=> $tank['tank_Id'],
                    "altura"=> floatval($tank['altura']),
                    'corte_agua' =>floatval($tank['corte_agua']),
                    "oil"=>round(floatval($tank['oil']),2),
                    "oil_des"=>round(floatval($tank['oil_des']),2),
                    "agua"=> round(floatval($tank['agua']),2),
                    "total"=>round(floatval($tank['total']),2),
                    "created_at"=> now(),
                    "updated_at"=> now(),                    
                ); 
                        
                OilDetail::insert($results);            
            } 
            $date=date_create($this->oil->fecha);                     
            date_add($date,date_interval_create_from_date_string("-1 days"));                          
            $this->fecha_anterior=date_format($date,"Y-m-d");
            $this->oil_ant= Oil::where(['fecha' =>$this->fecha_anterior, 'area_id'=>1])->first(); 
          
            if (is_null($this->oil_ant)){    
                //Sumo Ventas
                dd('esnulo');
                $ventasH= Sale::select('total')->where([ 'fecha' => $this->oil->fecha,'area_id' =>1])->get()->sum('total');                
                $ventasH = $ventasH ??  0;
                $ventasD = Sale::where( ['fecha'  => $this->oil->fecha,'area_id' =>1])->get()->sum('total_des');
                $ventasD = $ventasD ??  0;  
    
                //Sumo Mov. Ext e Internos que afectan a producción
                $movint= Movement::select('volumen')->where(['tipo'=>'mov_int','fecha'=> $this->oil->fecha, 'area_id' =>1])->get()->sum('volumen');    
                $movint = $movint ??  0;
                $movext= Movement::select('volumen')->where(['tipo'=>'mov_ext', 'fecha' => $this->oil->fecha, 'area_id' =>1])->get()->sum('volumen');
                $movext = $movext ??  0;
            
                $stock_oilH_ant= 0;
                $stock_oilH_dia= OilDetail::where('oil_id', $this->oilId)->get()->sum('oil');
    
                $stock_oilH_ant= 0;
                $stock_oilH_dia= OilDetail::where('oil_id', $this->oilId)->get()->sum('oil');
        
                $stock_oilD_ant=0;        
                $stock_oilD_dia= OilDetail::where('oil_id',$this->oilId)->get()->sum('oil_des');
        
                $stock_agua_ant=0;
                $stock_agua_dia= OilDetail::where('oil_id', $this->oilId)->get()->sum('agua');
        
                $stock_total_ant=0;
                $stock_total_dia=OilDetail::where('oil_id', $this->oilId)->get()->sum('total');           
    
                Oil::query()
                ->where('id', $this->oilId)           
                ->update([
                    "stock_oil_h" =>  OilDetail::where('oil_id', $this->oilId)->get()->sum('oil'),
                    "stock_oil_d" => OilDetail::where('oil_id', $this->oilId)->get()->sum('oil_d'),
                    "stock_agua" =>$stock_agua_dia,
                    "total_venta_h" => $ventasH,
                    "total_venta_d" => $ventasD,
                    "mov_ext" =>$movext,
                    "mov_int" =>$movint,
                    "stock_total" =>$stock_total_dia,
                    "prod_oil_h" =>($stock_oilH_dia -$stock_oilH_ant+$ventasH),                
                    "prod_oil_d" => ($stock_oilD_dia -$stock_oilD_ant+$ventasD ) ,
                    "prod_agua" => ($stock_oilH_dia -$stock_oilH_ant+$ventasH)-($stock_total_dia-$stock_total_ant+$ventasH+$movint-$movext),
                    "prod_bruta"  => ($stock_total_dia-$stock_total_ant+$ventasH+$movint-$movext),  
                    "estado"  => 'Modificado',  
                    "updated_at"=> now(), 

                ]);
            }else{    
                
                //Sumo Ventas
                $ventasH= Sale::select('total')->where([ 'fecha' => $this->oil->fecha,'area_id' =>1])->get()->sum('total');                
                $ventasH = $ventasH ??  0;
                $ventasD = Sale::where( ['fecha'  => $this->oil->fecha,'area_id' =>1])->get()->sum('total_des');
                $ventasD = $ventasD ??  0;  
    
                //Sumo Mov. Ext e Internos que afectan a producción
                $movint= Movement::select('volumen')->where(['tipo'=>'mov_int','fecha'=> $this->oil->fecha, 'area_id' =>1])->get()->sum('volumen');    
                $movint = $movint ??  0;
                $movext= Movement::select('volumen')->where(['tipo'=>'mov_ext', 'fecha' => $this->oil->fecha, 'area_id' =>1])->get()->sum('volumen');
                $movext = $movext ??  0;
                
                $movext_gaso= Movement::select('volumen')->where(['fecha' => $this->oil->fecha,'tipo'=>'mov_ext', 'tdestino'=>'T', 'area_id' =>1,'product_id' =>3])->get()->sum('volumen');
                $movext_gaso = $movext_gaso ??  0;  
          
                $stock_oilH_ant= Oil::where([ 'fecha' =>$this->fecha_anterior])->get()->sum('stock_oil_h');
                $stock_oilH_dia= OilDetail::where('oil_id', $this->oilId)->get()->sum('oil');
        
                $stock_oilD_ant= Oil::where([ 'fecha' =>$this->fecha_anterior])->get()->sum('stock_oil_d');        
                $stock_oilD_dia= OilDetail::where('oil_id',$this->oilId)->get()->sum('oil_des');
               // dd('stok ant: ' . $stock_oilD_ant .' Sotk Hoy: ' .$stock_oilD_dia. ' diferencia:' ($stock_oilD_dia-$stock_oilD_ant) );
                $stock_agua_ant= Oil::where([ 'fecha' =>$this->fecha_anterior])->get()->sum('stock_agua');
                $stock_agua_dia= OilDetail::where('oil_id', $this->oilId)->get()->sum('agua');
        
                $stock_total_ant=Oil::where([ 'fecha' =>$this->fecha_anterior])->get()->sum('stock_total');
                $stock_total_dia=OilDetail::where('oil_id', $this->oilId)->get()->sum('total');           
    
                Oil::query()
                ->where('id', $this->oilId)           
                ->update([
                    "stock_oil_h" =>  OilDetail::where('oil_id', $this->oilId)->get()->sum('oil'),
                    "stock_oil_d" => OilDetail::where('oil_id', $this->oilId)->get()->sum('oil_des'),
                    "stock_agua" =>$stock_agua_dia,
                    "total_venta_h" => $ventasH,
                    "total_venta_d" => $ventasD,
                    "mov_ext" =>$movext,
                    "mov_int" =>$movint,
                    "stock_total" =>$stock_total_dia,
                    "prod_oil_h" =>($stock_oilH_dia -$stock_oilH_ant+$ventasH-$movext),                
                    "prod_oil_d" => ($stock_oilD_dia -$stock_oilD_ant+$ventasD-$movext) ,
                    "prod_agua" =>(($stock_total_dia-$stock_total_ant+$ventasH+$movint-$movext)-($stock_oilH_dia -$stock_oilH_ant+$ventasH-$movext)),
                    "prod_bruta"  =>  ($stock_total_dia-$stock_total_ant+$ventasH+$movint-$movext),  
                    "estado"  => 'Modificado',  
                    "updated_at"=> now(), 
                ]);
            }   
        //    DB::commit();     
            session()->flash('message','Se han guardado satisfactoriamente los datos!!');
            return redirect()->to('/oil');

      //  }catch(\Exception $e){
       //     DB::rollBack();
            //return $e->getMessage();
       //     session()->flash('msg-error',$e->getMessage());
            

       // }    

    }


   public function verificaControl(){    
        $tankControl=TankControl::where(['tank_id' => $this->oil->tankId])->orderBy('created_at', 'desc')->first();  
        if (is_null($tankControl)){
            session()->flash('msg-error','No existen datos de control para tanque seleccionado, no se puede continuar.');
      
        }

   }


}

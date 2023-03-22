<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Tank;
use App\Models\Client;
use App\Models\Htablet;
use Carbon\Carbon;
use DateTime;
Use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class SaleCreate extends Component
{
    public $sale;
    public $saleId;
    public $fecha=null,$total,$primerDia;
    public $products, $product_id;
    public $tanks,$tank_id;
    public $action;
    public $button;

   
    protected function getRules(){   
        if( $this->action == "updateSale"){
            $rules = [
                'sale.fecha' => 'required|min:10|max:10|',
            ];
        }else{
            $rules = [
                'sale.fecha' => 'required|min:10|max:10|',
            ];

        }
        return array_merge([
            'sale.area_id'    =>  'required' ,
            'sale.product_id' =>  'required',
            'sale.tank_id'    =>  'required' ,
            'sale.total'      =>  'required' ,
            'sale.aguaporce'      =>  'required' ,
            'sale.remito'     =>  'required|min:3|max:13|',
            'sale.obs'        =>  'nullable'
            
        ], $rules);

    }


    public function createSale(){
        $this->resetErrorBag();
        $this->validate();    
        $results =[               
            'area_id' => 1,
            'fecha' => $this->sale->fecha,
            'remito' => $this->sale->remito,
            'product_id' => $this->sale->product_id,
            'tank_id' => $this->sale->tank_id,
            'total' => $this->sale->total,
            'aguaporce' => floatval($this->sale->aguaporce),
            'total_des' => floatval($this->sale->total-($this->sale->aguaporce* $this->sale->total/100)),
            'obs' => $this->sale->obs,
            "estado" => 'Creado',

         ];
         Sale::insert($results);    

        $this->emit('saved');
        $this->reset('sale');
        return redirect()->to('/sale');

    }

    public function updateSale() {
        $this->resetErrorBag();
        $this->validate();

        Sale::query()
            ->where('id', $this->saleId)           
            ->update([
                "fecha" => $this->sale->fecha,
                "remito" => $this->sale->remito,
                "product_id" => $this->sale->product_id,
                "total" => $this->sale->total,
                'aguaporce' => $this->sale->aguaporce,
                'total_des' => floatval($this->sale->total-($this->sale->aguaporce* $this->sale->total/100)),
                "obs" => $this->sale->obs,
                "area_id" => 1,
                "estado" => 'Modificado',

      
            ]);
         
        $this->emit('saved');
        $this->reset('sale');
        return redirect()->to('/sale');

    }

    public function mount (){
        if (!$this->sale && $this->saleId) {
            $this->sale = Sale::find($this->saleId);
            $this->sale->total;

        }else{
            $this->sale = new Sale;
            $fecha_hoy= now()->format('Y-m-d');
            $date=date_create($fecha_hoy);             
            if(Auth::user()->hasRole('Supervisor')){                
                $this->sale->fecha=date_format($date,"d-m-Y"); 
            }else{
                date_add($date,date_interval_create_from_date_string("-1 days")); 
                $this->sale->fecha=date_format($date,"d-m-Y");
            }  
            $this->sale->area_id=1;
            $this->primerDia=(new DateTime($this->sale->fecha))->modify('first day of this month')->format('d-m-Y');;
  
        }

        $this->button = create_button($this->action, "Sale");
    }

    public function render(){
        $this->products=Product::all();
        $this->tanks = Tank::select('*')->where( ['estado' => 'Activo', 'area_id' => 1])->get();      
          
        if (is_null($this->fecha)) {
            $fecha_hoy= now()->format('Y-m-d');
            $date=date_create($fecha_hoy);
            date_add($date,date_interval_create_from_date_string("-1 days"));
            $this->fecha= date_format($date,"Y-m-d");
       }
        return view('livewire.sale-create',[
        'products' => $this->products,
        'tanks' => $this->tanks,
        ]);
    }
}

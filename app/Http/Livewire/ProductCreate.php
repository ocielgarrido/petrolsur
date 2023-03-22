<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductCreate extends Component
{
    public $product;
    public $productId;
    public $action;
    public $button;

   
    protected function getRules(){   
        if( $this->action == "updateProvider"){
            $rules = [
                'product.nombre' => 'required|min:3|max:30|unique:providers,nombre,' .$this->productId,
            ];
        }else{
            $rules = [
                'product.nombre' => 'required|min:3|max:30|unique:providers,nombre',
            ];

        }
        return array_merge([
            'product.production' => 'required|in:Sí,No',
  
        ], $rules);

    }


    public function createProduct(){
        $this->resetErrorBag();
        $this->validate();    

        Product::create($this->product);

        $this->emit('saved');
        $this->reset('product');
        return redirect()->to('/product');

    }

    public function updateProduct() {
        $this->resetErrorBag();
        $this->validate();

        Product::query()
            ->where('id', $this->productId)           
            ->update([
                "nombre" => $this->product->nombre,
                "production" => $this->product->production,
   
            ]);
         
        $this->emit('saved');
        $this->reset('product');
        return redirect()->to('/product');

    }

    public function mount ()
    {
        if (!$this->product && $this->productId) {
            $this->product = Product::find($this->productId);
        }

        $this->button = create_button($this->action, "Product");
    }

    public function render()
    {
        return view('livewire.product-create');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Provider;

class ProviderCreate extends Component
{
    public $provider;
    public $providerId;
    public $action;
    public $button;

   
    protected function getRules(){   
        if( $this->action == "updateProvider"){
            $rules = [
                'provider.email' => 'required|email|min:10|max:50|unique:providers,email,'.$this->providerId,
                'provider.nombre' => 'required|min:3|max:30|unique:providers,nombre,' .$this->providerId,
                'provider.cuit' =>'required|min:11|max:11|unique:providers,cuit,' .$this->providerId,    
            ];
        }else{
            $rules = [
                'provider.email' => 'required|email|min:10|max:50|unique:providers,email',
                'provider.nombre' => 'required|min:3|max:30|unique:providers,nombre',
                'provider.cuit' =>'required|min:11|max:11|unique:providers,cuit',    
            ];

        }
        return array_merge([
            'provider.direccion' => 'required|max:50',
            'provider.telefono' =>   'required|min:7|max:20' 

        ], $rules);

    }


    public function createProvider(){
        $this->resetErrorBag();
        $this->validate();    

        Provider::create(
            [
                "nombre" => $this->provider->nombre,
                "cuit" => $this->provider->cuit,
                "email" => $this->provider->email,
                "direccion" => $this->provider->direccion,
                "telefono" => $this->provider->telefono,
                "estado" => 'Activo',
               
            ]
        );
        $this->emit('saved');
        $this->reset('provider');
        return redirect()->to('/provider');

    }

    public function updateProvider() {
        $this->resetErrorBag();
        $this->validate();

        Provider::query()
            ->where('id', $this->providerId)           
            ->update([
                "nombre" => $this->provider->nombre,
                "cuit" => $this->provider->cuit,
                "email" => $this->provider->email,
                "direccion" => $this->provider->direccion,
                "telefono" => $this->provider->telefono,
                "estado" => 'Activo',
 
            ]);
         
        $this->emit('saved');
        $this->reset('provider');
        return redirect()->to('/provider');

    }

    public function mount ()
    {
        if (!$this->provider && $this->providerId) {
            $this->provider = Provider::find($this->providerId);
        }else{

            $this->provider = new provider;
  
        }

        $this->button = create_button($this->action, "Provider");
    }

    public function render()
    {
        return view('livewire.provider-create');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ClientCreate extends Component
{
 //   public $nombre,$cuit,$email, $direccion, $telefono; 
    public $client;
    public $clientId;
    public $action;
    public $button;

   
    protected function getRules(){   
        if( $this->action == "updateClient"){
            $rules = [
                'client.email' => 'required|email|min:10|max:50|unique:clients,email,'.$this->clientId,
                'client.nombre' => 'required|min:3|max:30|unique:clients,nombre,' .$this->clientId,
                'client.cuit' =>'required|min:11|max:11|unique:clients,cuit,' .$this->clientId,    
            ];
        }else{
            $rules = [
                'client.email' => 'required|email|min:10|max:50|unique:clients,email',
                'client.nombre' => 'required|min:3|max:30|unique:clients,nombre',
                'client.cuit' =>'required|min:11|max:11|unique:clients,cuit',    
            ];

        }
        return array_merge([
            'client.direccion' => 'required|max:50',
            'client.telefono' =>   'required|min:7|max:20' 

        ], $rules);

    }


    public function createClient(){
        $this->resetErrorBag();
        $this->validate();    

        Client::create($this->client);

        $this->emit('saved');
        $this->reset('client');
        return redirect()->to('/client');
    }

    public function updateClient() {
        $this->resetErrorBag();
        $this->validate();

        Client::query()
            ->where('id', $this->clientId)           
            ->update([
                "nombre" => $this->client->nombre,
                "cuit" => $this->client->cuit,
                "email" => $this->client->email,
                "direccion" => $this->client->direccion,
                "telefono" => $this->client->telefono,
                "estado" => 'Activo',
 
            ]);
         
        $this->emit('saved');
        $this->reset('client');
        return redirect()->to('/client');
 
    }

    public function mount ()
    {
        if (!$this->client && $this->clientId) {
            $this->client = Client::find($this->clientId);
        }

        $this->button = create_button($this->action, "Client");
    }

    public function render()
    {
        return view('livewire.client-create');
    }

   
}

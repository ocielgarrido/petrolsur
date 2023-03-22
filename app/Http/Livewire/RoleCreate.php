<?php

namespace App\Http\Livewire;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Createrole extends Component
{
    public $role;
    public $roleid;
    public $action;
    public $button;

    protected function getRules()
    {
        $rules =[
            'role.name' => 'required|min:5|name|unique:roles,name,' . $this->roleId
        ];

        return array_merge([
            'role.name' => 'required|min:5|name|unique:roles,name,' . $this->roleId
        ], $rules);
    }

    public function createrole ()
    {
        $this->resetErrorBag();
        $this->validate();

        $password = $this->role['password'];

        if ( !empty($password) ) {
            $this->role['password'] = Hash::make($password);
        }

        role::create($this->role);

        $this->emit('saved');
        $this->reset('role');
    }

    public function updaterole ()
    {
        $this->resetErrorBag();
        $this->validate();

        role::query()
            ->where('id', $this->roleId)
            ->update([
                "name" => $this->role->name,
                "email" => $this->role->email,
            ]);

        $this->emit('saved');
    }

    public function mount ()
    {
        if (!$this->role && $this->roleId) {
            $this->role = role::find($this->roleId);
        }

        $this->button = create_button($this->action, "role");
    }

    public function render()
    {
        return view('livewire.create-role');
    }

    public function volver(){
        return view('pages.role.role-data');
    }
}

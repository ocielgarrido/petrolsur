<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use App\Models\Backup;

class BackupComponent extends Component
{
    public $showData = true;
     //Modelo
     public $backup;
  
     public function showForm()
     {
         $this->showData = true;
     }
     
    public function render()
    {
      
        $backups = Backup::orderBy('id', 'DESC')->get();
        return view('livewire.backup-component',['backups' => $backups]);
    }
}

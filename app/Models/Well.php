<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Well extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'idpozo',
        'yacimiento_id',
        'pozo', //string 15
        'well_formation_id',
        'cap_iv_nombre',
        'latitud',
        'longitud',
        'cord_x',
        'coor_y',
        'profundidad',
        'perfo_ini',
        'perfo_fin',
        'termi_ini',
        'termi_fin',
        'cota',
        'prod_oil_dic',
        'prod_gas_dic',
        'prod_agua_dic',
        'iny_agua_dic',
        'iny_gas_dic',
        'iny_co_dic',
        'iny_otr_dic',
        'vida_util_dic',
        'abandono',
        'capacidad',
        'well_state_id', //PE=produccion efectiva, PT=parado transitorio, PE=parado en estudio (ARAP Cap IV)
        'pet', //Tipo pozo GAS PET 
        'pist'  //tipo extraccion 
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::join('well_controls','well.id','=', 'well_control.wel_id_id')
                ->where('pozo', 'like', '%'.$query.'%')
                ->orWhere('cap_iv_nombre', 'like', '%'.$query.'%')
                ->orWhere('tipo', 'like', '%'.$query.'%')
                ->orWhere('arap', 'like', '%'.$query.'%')
                ->orWhere('pozo', 'like', '%'.$query.'%')
                ->orWhere('well_formation_id', 'like', '%'.$query.'%');

    }

   
   public function WellState(){
        return $this->hasOne("App\Models\WellState");
    }
 
    public function well_state() {
        return $this->belongsTo(WellState::class);
    }

    public function WellFormation(){
        return $this->hasOne("App\Models\WellFormation");
    }
  
    public function well_formation() {
        return $this->belongsTo(WellFormation::class);
    }

    public function WellControl(){
        return $this->hasMany("App\Models\WellControl");
  
    }
  
    public function WellIntervention(){
        return $this->hasMany("App\Models\WellIntervention");
  
    }
 
  
}

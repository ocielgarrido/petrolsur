<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWellControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('well_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained();
            $table->foreignId('well_id')->constrained('wells');
            $table->date('fecha');
            $table->integer('horas');
            $table->double('agua_emul_por', 7,4)->default(0); 
            $table->double('prod_bruta_m3', 7,2)->default(0); 
            $table->double('oil_neto_mt3', 7,2)->default(0); 
            $table->double('agua_neto_mt3', 7,2)->default(0); 
            $table->integer('gas_neto_mt3'); 
            $table->double('prod_bruta_24', 7,2)->default(0); 
            $table->double('oil_neto_24', 7,2)->default(0); 
            $table->double('agua_neto_24', 7,2)->default(0); 
            $table->integer('gas_neto_24'); 
            $table->integer('carrera');
            $table->double('gpm', 7,2)->default(0); 
            $table->integer('orificio');             
            $table->boolean('estado')->default(false);       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('well_controls');
    }
}

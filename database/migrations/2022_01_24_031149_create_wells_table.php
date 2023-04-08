<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id');
            $table->foreignId('yacimiento_id');
            $table->string('pozo',20); 
            $table->foreignId('well_formation_id',);
            $table->string('cap_iv_nombre',20)->nullable(); 
            $table->decimal('latitud',10,8)->nullable();  //varia -90 a +90
            $table->decimal('longitud',10,8)->nullable(); //varia -180 a +180
            $table->decimal('cord_x',10,2)->nullable();
            $table->decimal('cord_y',10,2)->nullable(); 
            $table->decimal('profundidad',6,1)->nullable();             
            $table->date('ferfo_ini')->nullable();
            $table->date('perfo_fin')->nullable();
            $table->date('termi_ini')->nullable();
            $table->date('termi_fin')->nullable();
            $table->foreignId('well_state_id');  
            $table->string('pet',10)->nullable(); 
            $table->string('pist',10)->nullable(); 
            $table->string('obs',255)->nullable(); 
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
        Schema::dropIfExists('wells');
    }
}

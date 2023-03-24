<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yacimiento_id')->constrained();
            $table->foreignId('well_id')->constrained();
            $table->string('pozo',20); 
            $table->date('fecha');
            $table->integer('m3gas_control')->nullable();
            $table->double('porce_prod',15,3)->nullable(); 
            $table->integer('mt3gas_declara')->nullable();
            $table->double('agua_declara',15,3)->nullable(); 
            $table->integer('total_mes')->nullable();
            $table->integer('total_gral')->nullable();            
            // campos para petroleo
           // 'bruta_m3',
           // 'agua',
           // 'neta_m3',
           // 'agua_m3',
           // 'porce_total',
           // 'bruta_declara',
           // 'neta_declara',    
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
        Schema::dropIfExists('calculos');
    }
}

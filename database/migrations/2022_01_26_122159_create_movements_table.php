<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained();
            $table->foreignId('client_id')->constrained();
            $table->date('fecha'); 
            $table->string('tipo',20);         
            $table->string('remito',20);    
            $table->double('agua_porce',4,1);         
            $table->double('densidad',4,3);         
            $table->integer('sales');         
            $table->integer('temperatura');         
            $table->double('altura_ini',5,2);  
            $table->double('corte_agua_ini',5,3);  
            $table->double('vol_oil_ini',5,3);  
            $table->double('vol_agua_ini',5,3);  
            $table->double('vol_total_ini',5,3);  
            $table->double('altura_fin',5,3);  
            $table->double('corte_agua_fin',5,3);  
            $table->double('vol_oil_fin',5,3);  
            $table->double('vol_agua_fin',5,3);  
            $table->double('vol_total_fin',5,2);  
            $table->double('volumen',5,3);  

  

   
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
        Schema::dropIfExists('movements');
    }
}

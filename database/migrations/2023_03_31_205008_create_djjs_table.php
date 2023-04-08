<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDjjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('djjs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id');
            $table->foreignId('well_id');
            $table->string('pozo',10); //nombre pozo para petrolsur
            $table->string('idpozo',10); // primer campo
            $table->double('prod_pet',10,2); //seg. campo
            $table->double('prod_gas',10,2);
            $table->double('prod_agua',10,2);
            $table->double('iny_agua',10,2);
            $table->double('iny_co',10,2);
            $table->double('iny_otro',10,2);
            $table->double('tef' ,10,2)->nullable();//dias
            $table->double('v_util',10,2); //vida util
            $table->foreignId('well_state_id'); //codigo estado pozo
            $table->string('pist',10); // Codigo Tipo Extracion
            $table->string('pet',10); //Tipo pozo    
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
        Schema::dropIfExists('djjs');
    }
}

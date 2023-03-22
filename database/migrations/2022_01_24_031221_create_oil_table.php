<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id');
            $table->date('fecha');
            $table->double('oil', 7,3); //oil mts
            $table->double('agua',7,3); //agua en mt3
            $table->double('total',7,3); //suma agua + oil
            $table->double('venta',7,3); //sumatoria vental del dia
            $table->double('oil_production',7,3);  
            $table->string('estado',20);   
            $table->text('obs'); 
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
        Schema::dropIfExists('oil');
    }
}

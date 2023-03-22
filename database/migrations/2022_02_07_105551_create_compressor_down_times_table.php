<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompressorDownTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compressor_down_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compressor_id')->constrained();            
            $table->foreignId('compressor_causes_id')->constrained();            
            $table->date('fecha');  
            $table->integer('horas');  
            $table->integer('horas_paro_msa');  
            $table->integer('horas_standby');  
            $table->text('obs'); 
            $table->string('estado', 15);
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
        Schema::dropIfExists('compressor_down_times');
    }
}

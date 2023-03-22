<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWellDownTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('well_down_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('well_id')->constrained();
            $table->date('fecha');  
            $table->integer('horas');  
            $table->foreignId('well_cause_id')->constrained();
            $table->double('agua_perdido_mt3', 7,2)->default(0); 
            $table->double('oil_perdido_mt3', 7,2)->default(0); 
            $table->double('gas_perdido_mt3', 7,2)->default(0);   
            $table->boolean('estado')->default(false);   
            $table->text('descrip');               
  
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
        Schema::dropIfExists('well_down_times');
    }
}

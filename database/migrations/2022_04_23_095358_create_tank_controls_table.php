<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTankControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tank_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained();
            $table->foreignId('tank_id')->constrained('tanks');
            $table->date('fecha');
            $table->double('agua', 7,2)->default(0); 
            $table->double('sales', 7,2)->default(0); 
            $table->double('temp', 7,2)->default(0); 
            $table->double('densidad', 7,2)->default(0); 
            $table->string('estado', 20); 
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
        Schema::dropIfExists('tank_controls');
    }
}

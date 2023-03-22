<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChePropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('che_props', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ches_id')->constrained();
            $table->double('pm',5,3);     
            $table->double('vm',5,3);     
            $table->double('dabs',5,3);     
            $table->double('drelat',5,3);     
            $table->double('pcsm3',5,3);     
            $table->double('pcskg',5,3);     
            $table->double('pcim3',5,3);     
            $table->double('iwobbe',5,3);     
            $table->double('cp',5,3);     
            $table->double('cv',5,3);     
            $table->double('k',5,3);     
            $table->double('compz',5,3);     
            $table->double('presion',5,3);     
            $table->double('temp',5,3);
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
        Schema::dropIfExists('che_props');
    }
}

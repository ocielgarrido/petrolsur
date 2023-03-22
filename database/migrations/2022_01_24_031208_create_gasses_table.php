<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gasses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id');
            $table->foreignId('client_id');
            $table->date('fecha');
            $table->integer('pm10');
            $table->integer('pm316');
            $table->integer('a9300');
            $table->integer('pm316_c');
            $table->integer('a9300_c');    
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
        Schema::dropIfExists('gasses');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id');
            $table->string('nombre',20);
            $table->integer('capacidad');
            $table->double('cte',4,3);
            $table->boolean('api');
            $table->integer('fabricacion');      
            $table->boolean('interno'); //si o no
            $table->double('alturaT',3,2); //altura total         
            $table->double('altura',3,2); //altura total         
            $table->double('largo',3,2); //altura total         
            $table->text('obs');
            $table->string('estado',20);    
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
        Schema::dropIfExists('tanks');
    }
}

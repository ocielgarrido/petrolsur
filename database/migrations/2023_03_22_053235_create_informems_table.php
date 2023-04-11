<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained();
            $table->date('fecha');
            $table->double('oilb', 7,2)->default(0); 
            $table->double('oilH', 7,2)->default(0); 
            $table->double('oilD', 7,2)->default(0); 
            $table->integer('pm10')->default(0); 
            $table->integer('pm316')->default(0); 
            $table->integer('a9300')->default(0); 
            $table->integer('cgas')->default(0); 
            $table->integer('tgas')->default(0); 
            $table->double('agua', 7,2)->default(0); 
            $table->double('ventas_oil', 7,2)->default(0); 
            $table->double('gasolina', 7,2)->default(0); 
            $table->string('fileCapIV', 50);     
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
        Schema::dropIfExists('informems');
    }
}

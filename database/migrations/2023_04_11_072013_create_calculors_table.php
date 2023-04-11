<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yacimiento_id')->constrained();
            $table->foreignId('well_id')->constrained();
            $table->double('bcr', 8,2)->nullable()->default(0); //bruta controles cb
            $table->double('ncr', 8,2)->nullable()->default(0); //neta controles  cd
            $table->double('acr', 8,2)->nullable()->default(0);  // agua controles ce 
            $table->double('porce', 8,2)->nullable()->default(0);  // % ajuste b35
            $table->double('ajuste', 8,2)->nullable()->default(0);  // ajuste es lo real que se informa b36    
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
        Schema::dropIfExists('calculors');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWellCauseParosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('well_causes', function (Blueprint $table) {
            $table->id();
            $table->string('causa',100);
            $table->foreignId('well_cause_categorie_id')->constrained();
            $table->string('descrip',200);                
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
        Schema::dropIfExists('well_causes');
    }
}

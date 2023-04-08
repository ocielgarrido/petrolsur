<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yacimiento_id')->constrained();
            $table->foreignId('well_id')->constrained();
            $table->string('pozo',20); 
            $table->date('dia');
            $table->date('fecha');
            $table->double('cb', 8,2)->nullable()->default(0);
            $table->double('cc', 8,2)->nullable()->default(0);
            $table->double('cd', 8,2)->nullable()->default(0);
            $table->double('ce', 8,2)->nullable()->default(0);
            $table->double('cf', 8,2)->nullable()->default(0);
            $table->double('cg', 8,2)->nullable()->default(0);
            $table->double('ch', 8,2)->nullable()->default(0);
            $table->double('ci', 8,2)->nullable()->default(0);
            $table->double('cj', 8,2)->nullable()->default(0);
            $table->double('oilB', 8,2)->nullable()->default(0);
            $table->double('oilD', 8,2)->nullable()->default(0);
            $table->double('aguaM3', 8,2)->nullable()->default(0);
            $table->double('aguaP', 8,2)->nullable()->default(0);
            $table->smallInteger('dias')->nullable()->default(0);
            $table->smallInteger('v_util')->nullable()->default(0);
            $table->string('pet', 10)->nullable()->default(0);
            $table->double('totalM', 15,2)->nullable()->default(0);
            $table->double('totalG', 15,2)->nullable()->default(0);
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
        Schema::dropIfExists('calculos');
    }
}

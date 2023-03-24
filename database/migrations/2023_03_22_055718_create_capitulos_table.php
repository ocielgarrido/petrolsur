<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capitulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained();
            $table->foreignId('yacimiento_id')->constrained();
            $table->foreignId('well_id')->constrained();
            $table->date('periodo');
            $table->smallInteger('secuencia')->default(0);
            $table->double('prod_oilH', 12,3)->default(0); 
            $table->double('prod_oilD',12,3)->default(0); 
            $table->double('prod_gas', 12,3)->default(0); 
            $table->double('prod_agua', 12,3)->default(0); 
            $table->double('prod_acum_oilH', 12,3)->default(0); 
            $table->double('prod_acum_oilD', 12,3)->default(0); 
            $table->double('prod_acum_gas', 12,3)->default(0); 
            $table->double('prod_acum_agua', 12,3)->default(0); 
            $table->double('iny_agua',12,3)->default(0); 
            $table->double('iny_gas',12,3)->default(0); 
            $table->double('iny_co', 12,3)->default(0); 
            $table->double('iny_otros',12,3)->default(0); 
            $table->double('rgp', 12,3)->default(0); 
            $table->double('porce_agua', 12,3)->default(0); 
            $table->double('tef', 12,3)->default(0); 
            $table->double('vida_util', 12,3)->default(0); 
            $table->string('sis_extrac', 30)->default(0); 
            $table->string('estado_well', 30)->default(0); 
            $table->string('tipo_well', 30)->default(0); 
            $table->text('obs', 7,2)->default(0); 
            $table->string('estado', 20)->default(0); 
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
        Schema::dropIfExists('capitulos');
    }
}

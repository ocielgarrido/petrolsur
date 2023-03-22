<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOilDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oil_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oil_id');
            $table->foreignId('tank_id');
            $table->double('altura',4,1); //altura total en cm
            $table->double('corte_agua', 4,1); //oil mts
            $table->double('oil',7,3); //stock petroleo del tanque (altura-corte_agua) * cte en mt3
            $table->double('agua',7,3);  // stock agua del tanque  (corte_agua * cte) en mt3
            $table->double('total',7,3); //oil +agua
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
        Schema::dropIfExists('oil_details');
    }
}

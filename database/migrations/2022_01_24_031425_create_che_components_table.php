<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('che_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ches_id')->constrained();
            $table->double('n2',4,3);     
            $table->double('co2',4,3);     
            $table->double('ch4',4,3);     
            $table->double('c2h6',4,3);     
            $table->double('c3h8',4,3);     
            $table->double('ic4h10',4,3);     
            $table->double('nc4h10',4,3);     
            $table->double('ic5h12',4,3);     
            $table->double('nc5h12',4,3);     
            $table->double('c6h14',4,3);     
            $table->double('c7h16',4,3);     
            $table->double('c8h18',4,3);     
            $table->double('o2',4,3);    
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
        Schema::dropIfExists('che_components');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTableWell extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wells', function (Blueprint $table) {
            $table->integer('idpozo')->default(0)->after('id');
            $table->double('cota',8,2)->default(0)->after('longitud');
            $table->double('prod_oil_dic',12,2)->default(0)->after('profundidad');
            $table->double('prod_gas_dic',12,2)->default(0)->after('prod_oil_dic');
            $table->double('prod_agua_dic',12,2)->default(0)->after('prod_gas_dic');
            $table->double('iny_agua_dic',12,2)->default(0)->after('prod_agua_dic');
            $table->double('iny_gas_dic',12,2)->default(0)->after('iny_agua_dic');
            $table->double('iny_co_dic',12,2)->default(0)->after('iny_gas_dic');
            $table->double('iny_otr_dic',12,2)->default(0)->after('iny_co_dic');
            $table->double('vida_util_dic',12,2)->default(0)->after('iny_otr_dic');
            $table->date('abandono')->nullable()->after('termi_fin');
            $table->double('capacidad',12,2)->default(0)->after('abandono');
            $table->boolean('exportado')->default(0)->after('tipo');
            $table->strng('arap',10)->default(0)->after('abandono');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrExistenciaDown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
                CREATE TRIGGER tr_ExistenciaDown AFTER INSERT ON detalle_venta
                FOR EACH ROW BEGIN
                UPDATE insumos SET existencia= existencia - NEW.cantidad
                WHERE insumos.id= NEW.idinsumo;
                END

        ');
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

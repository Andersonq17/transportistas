<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrExistenciaUp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER tr_ExistenciaUp AFTER INSERT ON detalle_ingresos
            FOR EACH ROW BEGIN
            UPDATE insumos SET existencia= existencia + NEW.cantidad
            WHERE insumos.id= NEW.idinsumo;
            END'
                    );
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineasTransporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('rif',20)->unique();
            $table->string('correo',50)->unique();
            $table->string('direccion',100)->nullable();
            $table->string('estado',30);
            $table->string('municipio',30)->nullable();
            $table->string('telefono',20)->nullable();
            $table->string('tipo_ruta',20);
            $table->integer('id_persona')->unsigned();
            $table->integer('id_sindicato')->unsigned();
            $table->string('cps',20)->nullable();
            $table->boolean('status')->default(1);

            $table->foreign('id_persona')->references('id')->on('personas');
            $table->foreign('id_sindicato')->references('id')->on('sindicato');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lineas');
    }
}

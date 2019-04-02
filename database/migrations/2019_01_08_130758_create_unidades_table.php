<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('marca',20);
            $table->string('modelo',20);
            $table->string('anio',4);
            $table->string('placa',10)->unique();
            $table->string('tipo',20);
            $table->string('numero_cupo',10)->nullable();
            $table->boolean('status')->default('1');
            $table->integer('id_linea')->unsigned()->nullable();
            $table->integer('id_persona')->unsigned()->nullable();
            $table->string('observaciones')->nullable();

            $table->foreign('id_linea')->references('id')->on('lineas')->onDelete('SET NULL');
            $table->foreign('id_persona')->references('id')->on('personas')->onDelete('SET NULL');


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
        Schema::dropIfExists('unidades');
    }
}

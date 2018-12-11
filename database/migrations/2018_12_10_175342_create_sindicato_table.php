<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSindicatoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sindicato', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',80)->unique();
            $table->string('rif',10)->unique();
            $table->string('direccion',120);
            $table->string('telefono',12)->nullable();
            $table->string('correo',50)->unique();
            $table->string('estado',50)->nullable();
            $table->integer('id_persona')->unsigned();

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
        Schema::dropIfExists('sindicato');
    }
}

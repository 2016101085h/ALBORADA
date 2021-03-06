<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaestrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maestros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50);
            $table->string('apellido', 100);
            $table->date('fech_nacimiento')->nullable();
            $table->string('sexo', 50)->nullable();
            $table->integer('dni')->nullable();
            $table->integer('num_celular')->nullable();
            $table->string('direccion', 256)->nullable();
            $table->string('grado_instruccion', 50)->nullable();
            $table->boolean('condicion')->default(1);
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
        Schema::dropIfExists('maestros');
    }
}

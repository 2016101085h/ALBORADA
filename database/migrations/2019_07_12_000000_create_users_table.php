<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('rol_id')->unsigned();
            $table->string('usuario', 50);
            $table->string('password');
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            $table->foreign('id')->references('id')->on('personas');
            $table->foreign('rol_id')->references('id')->on('rols');
        });
        DB::table('users')->insert(array('id' => 1, 'rol_id' => 1, 'usuario' => 'frank', 'password' => bcrypt('123'), 'condicion' => 1));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

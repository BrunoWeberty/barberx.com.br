<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 150);
            $table->string('login', 50)->unique();
            $table->string('email', 100);
            $table->string('senha');
            $table->string('status', 1);
            $table->string('tipo', 1);
            $table->string('telefone', 30)->nullable();
            $table->string('endereco', 150)->nullable();
            $table->string('cpf', 15)->nullable();
            $table->string('sexo', 1)->nullable();
            $table->string('menu', 1)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}

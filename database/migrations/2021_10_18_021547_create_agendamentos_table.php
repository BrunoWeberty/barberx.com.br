<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamento', function (Blueprint $table) {
            $table->increments('idAgendamento');
            $table->integer('idCliente')->unsigned();
            $table->integer('idFunc')->unsigned();
            $table->datetime('dataHora');
            $table->string('descricao')->nullable();
            $table->double('total', 8, 2);
            $table->string('status', 1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('agendamento', function($table) {
            $table->foreign('idCliente')->references('id')->on('usuario');
            $table->foreign('idFunc')->references('id')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamento');
    }
}

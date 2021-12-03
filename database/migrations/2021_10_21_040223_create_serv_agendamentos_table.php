<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servagendamento', function (Blueprint $table) {
            $table->increments('idServAgendamento');
            $table->integer('idAgendamento')->unsigned();
            $table->integer('idServico')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('servagendamento', function($table) {
            $table->foreign('idAgendamento')->references('idAgendamento')->on('agendamento');
            $table->foreign('idServico')->references('idServico')->on('servico');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servagendamento');
    }
}

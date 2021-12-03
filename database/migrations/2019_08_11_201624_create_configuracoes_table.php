<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email',255);
            $table->string('email2',255);
            $table->string('emailSenha',200);
            $table->string('emailHost',200);
            $table->string('nomeAplicacao',100);
            $table->date('inicioLicenca');
            $table->date('fimLicenca');
            $table->string('empresa')->nullable();
            $table->string('keywords')->nullable();
            $table->string('titulo',500)->nullable();
            $table->string('descricao',1000)->nullable();
            $table->string('url',300)->nullable();
            $table->string('favicon',300)->nullable();
            $table->string('logo',300)->nullable();
            $table->string('versao')->nullable();
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
        Schema::dropIfExists('Tconfiguracoes');
    }
}

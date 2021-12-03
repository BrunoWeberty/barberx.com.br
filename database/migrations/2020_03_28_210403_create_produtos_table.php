<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->increments('idProduto');
            $table->integer('idMarca')->unsigned();
            $table->string('descricao');
            $table->string('img',150)->nullable();
            $table->double('valor', 8, 2);
            $table->string('ativo',1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('produto', function($table) {
            $table->foreign('idMarca')->references('idMarca')->on('marca');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto');
    }
}

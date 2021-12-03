<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemvenda', function (Blueprint $table) {
            $table->increments('idItemVenda');
            $table->integer('idVenda')->unsigned();
            $table->integer('idProduto')->unsigned();
            $table->integer('quantidade');
            $table->double('valor', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('itemvenda', function($table) {
            $table->foreign('idVenda')->references('idVenda')->on('venda');
            $table->foreign('idProduto')->references('idProduto')->on('produto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itemvenda');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jumlah');
            $table->integer('nota_id')->unsigned();
            $table->bigInteger('biaya'); // satuan
            $table->integer('inventory_id')->unsigned();
            $table->integer('inventory_jenis')->unsigned();
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
        Schema::dropIfExists('item_transaksi');
    }
}

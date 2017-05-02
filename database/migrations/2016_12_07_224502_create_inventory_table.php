<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('merek');
            $table->integer('jenis_id')->unsigned();
            $table->integer('modal_id')->unsigned();
            $table->bigInteger('harga_beli');
            $table->date('tanggal_masuk');
            $table->date('tanggal_kadaluarsa');
            $table->integer('jumlah');
            $table->integer('jumlah_aktual');
            $table->integer('jumlah_karung');
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
        Schema::dropIfExists('inventory');
    }
}

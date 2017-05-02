<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('tanggal');
            $table->bigInteger('total_modal');
            $table->bigInteger('total_harga');
            $table->bigInteger('total_pembayaran');
            $table->bigInteger('keuntungan_bersih');
            $table->integer('konsumen_id')->unsigned();
            $table->integer('status');
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('nota');
    }
}

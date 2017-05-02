<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengeluaranLainnyaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_lainnya', function (Blueprint $table) {
            $table->increments('id');           
            $table->integer('jenis_operasional_id')->unsigned();
            $table->string('uraian');
            $table->integer('user_id')->unsigned();
            $table->timestamp('tanggal');
            $table->bigInteger('biaya');
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
        Schema::dropIfExists('pengeluaran_lainnya');
    }
}

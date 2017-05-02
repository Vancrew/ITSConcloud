<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKonsumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konsumen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->string('telepon')->nullable();
            $table->string('hp')->nullable();
            $table->string('nama_restoran');
            $table->string('telepon_restoran')->nullable();
            $table->string('nama_cp');
            $table->string('telepon_cp');
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
        Schema::dropIfExists('konsumen');
    }
}

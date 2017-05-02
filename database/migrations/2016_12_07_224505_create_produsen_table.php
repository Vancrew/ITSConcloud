<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdusenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produsen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('hp');
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
        Schema::dropIfExists('produsen');
    }
}

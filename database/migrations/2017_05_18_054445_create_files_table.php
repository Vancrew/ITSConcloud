<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext')->nullable();
            $table->string('name')->nullable();
            $table->string('mime')->nullable();
            $table->string('random_name')->nullable();
            $table->string('path')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('size')->unsigned();
            $table->string('jenis_file');
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
        Schema::dropIfExists('files');
    }
}

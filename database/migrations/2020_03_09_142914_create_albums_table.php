<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('album_name');  //varchar(100)
            $table->string('album_artist'); //varchar(100)
            $table->string('producer'); //varchar(100)
            $table->date('release_date');
            $table->binary('album_art');
            $table->float('price');
            $table->float('rating');
            $table->longText('album_des');
            $table->string('album_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}

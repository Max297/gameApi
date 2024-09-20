<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gameGenres', function (Blueprint $table) {
            $table->unsignedInteger('gameId');
            $table->string('genre',255);
            $table->foreign('gameId')->references('id')->on('games')->onDelete('cascade');
            $table->primary(['genre','gameId']);
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
        Schema::dropIfExists('gameGenres');
    }
}

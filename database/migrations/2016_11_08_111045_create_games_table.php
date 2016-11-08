<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle');
            $table->string('desc_md');
            $table->string('desc_html');
            $table->string('website_url');
            $table->integer('user_id');
            $table->integer('views');
            $table->date('release_date');
            $table->integer('maker_id');
            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id');
            $table->index('maker_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
    }
}
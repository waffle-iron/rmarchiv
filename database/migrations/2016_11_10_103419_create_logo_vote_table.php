<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogoVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logo_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('logo_id');
            $table->integer('user_id');
            $table->integer('up');
            $table->integer('down');
            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id');
            $table->index('logo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('logo_votes');
    }
}

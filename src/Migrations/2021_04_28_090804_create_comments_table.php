<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id');
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('user_id');
            $table->longText('content');
            $table->timestamps();
        });

        Schema::table(config('badaso.database.prefix').'comments', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on(config('badaso.database.prefix').'posts')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on(config('badaso.database.prefix').'comments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on(config('badaso.database.prefix').'users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('badaso.database.prefix').'comments');
    }
}

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
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('post_id');
            $table->uuid('parent_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->longText('content');
            $table->timestamps();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}

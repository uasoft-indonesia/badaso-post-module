<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'post_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('post_id');
            $table->uuid('tag_id');
        });

        Schema::table(config('badaso.database.prefix').'post_tag', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on(config('badaso.database.prefix').'posts')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on(config('badaso.database.prefix').'tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('badaso.database.prefix').'post_tag');
    }
}

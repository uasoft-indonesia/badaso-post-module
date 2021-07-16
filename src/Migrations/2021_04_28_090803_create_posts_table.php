<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('title');
            $table->string('slug', 255)->unique();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->tinyInteger('published')->default(0);
            $table->bigInteger('comment_count');
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
        });

        Schema::table(config('badaso.database.prefix').'posts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on(config('badaso.database.prefix').'users');
            $table->foreign('parent_id')->references('id')->on(config('badaso.database.prefix').'posts')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on(config('badaso.database.prefix').'categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('badaso.database.prefix').'posts');
    }
}

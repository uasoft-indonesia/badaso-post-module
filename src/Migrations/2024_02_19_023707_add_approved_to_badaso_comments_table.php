<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedToBadasoCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('badaso.database.prefix') . 'comments', function (Blueprint $table) {
             $table->boolean('approved')->default(false)->after('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('badaso.database.prefix') . 'comments', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
}

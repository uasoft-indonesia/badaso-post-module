<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestEmailToBadasoCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('badaso.database.prefix') . 'comments', function (Blueprint $table) {
            $table->string('guest_email')->nullable()->after('guest_name');
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
            $table->dropColumn('guest_email');
        });
    }
}

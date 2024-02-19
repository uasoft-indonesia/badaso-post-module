<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestNameToBadasoCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('badaso.database.prefix') . 'comments', function (Blueprint $table) {
             $table->string('guest_name')->nullable()->after('parent_id');
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
            $table->dropColumn('guest_name');
        });
    }
}

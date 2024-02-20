<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToBadasoCommentsTable extends Migration
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
            $table->string('guest_email')->nullable()->after('guest_name');
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
            $table->dropColumn('guest_name');
            $table->dropColumn('guest_email');
            $table->dropColumn('approved');
        });
    }
}

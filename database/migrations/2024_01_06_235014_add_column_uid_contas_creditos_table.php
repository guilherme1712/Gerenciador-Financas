<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUidContasCreditosTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contas', function (Blueprint $table) {
            $table->integer('uid')->after('id');
        });

        Schema::table('creditos', function (Blueprint $table) {
            $table->integer('uid')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contas', function (Blueprint $table) {
            $table->dropColumn('uid');
        });

        Schema::table('creditos', function (Blueprint $table) {
            $table->dropColumn('uid');
        });
    }
}

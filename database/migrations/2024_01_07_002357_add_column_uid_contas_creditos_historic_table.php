<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUidContasCreditosHistoricTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contasHistorico', function (Blueprint $table) {
            $table->integer('uid')->after('id');
        });

        Schema::table('creditosHistorico', function (Blueprint $table) {
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
        Schema::table('contasHistorico', function (Blueprint $table) {
            $table->dropColumn('uid');
        });

        Schema::table('creditosHistorico', function (Blueprint $table) {
            $table->dropColumn('uid');
        });
    }
}
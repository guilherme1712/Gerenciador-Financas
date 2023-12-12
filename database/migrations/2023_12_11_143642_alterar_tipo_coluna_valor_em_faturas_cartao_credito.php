<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterarTipoColunaValorEmFaturasCartaoCredito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faturas_cartao_credito', function (Blueprint $table) {
            $table->decimal('valor', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faturas_cartao_credito', function (Blueprint $table) {
            $table->double('valor')->change();
        });
    }
}

<?php

// Em um novo arquivo de migration (por exemplo, create_faturas_cartao_credito_table.php)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaturasCartaoCreditoTable extends Migration
{
    public function up()
    {
        Schema::create('faturas_cartao_credito', function (Blueprint $table) {
            $table->id();
            $table->string('mes_referencia');
            $table->float('valor')->default(0);
            $table->integer('dia_fechamento');
            $table->integer('dia_vencimento');
            $table->boolean('status')->default(0); // 0 para não paga, 1 para paga
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faturas_cartao_credito');
    }
}

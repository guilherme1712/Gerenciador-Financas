<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->string('nome');
            $table->string('secao');
            // $table->timestamps(); // Isso criará as colunas 'created_at' e 'updated_at'

            // Configurando 'created_at' com valor padrão current_timestamp
            $table->timestamp('created_at')->useCurrent();

            // Definindo a chave estrangeira, se necessário
            // $table->foreign('categoria_id')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}

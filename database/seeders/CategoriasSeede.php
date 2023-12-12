<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeede extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            '1' => 'Conta Fixa',
            '2' => 'Mercado',
            '3' => 'Carro',
            '4' => 'Cartão Crédito',
            '5' => 'Outros',
        ];

        foreach ($categorias as $categoriaId => $nome) {
            DB::table('categorias')->insert([
                'categoria_id' => $categoriaId,
                'nome' => $nome,
                'secao' => 1,
                'created_at' => now(),
            ]);
        }
    }
}

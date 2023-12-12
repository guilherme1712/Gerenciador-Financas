<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutrasCategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            '1' => 'Salário',
            '2' => 'Transferência',
            '3' => 'Pix',
            '4' => 'Outros',
        ];

        foreach ($categorias as $categoriaId => $nome) {
            DB::table('categorias')->insert([
                'categoria_id' => $categoriaId,
                'nome' => $nome,
                'secao' => 2, // Valor fixo para a coluna 'secao'
                'created_at' => now(),
            ]);
        }
    }
}

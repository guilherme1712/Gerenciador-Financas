<?php

// app/Models/Categoria.php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Admin
{
    public static function allCategoria()
    {
        return DB::table('categorias')->get();
    }

    public static function addCategoria(array $data)
    {
        $dataInsert = [
            'categoria_id' => $data['categoria_id'],
            'nome' => $data['nome'],
            'secao' => $data['secao'],
            'created_at' => date('Y-m-d H:i:s'),
        ];

        return DB::table('categorias')->insertGetId($dataInsert);
    }

    public static function updateCategoria(int $id, array $data)
    {
        DB::table('categorias')
            ->where('id', $id)
            ->update($data);
    }

    public static function findCategoria($id)
    {
        return DB::table('categorias')->find($id);
    }

    
    public static function deleteCategoria($id)
    {
        return DB::table('categorias')->where('id', $id)->delete();
    }
}

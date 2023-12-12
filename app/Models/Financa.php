<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Financa extends Model
{

    public function searchBillings(int $id = null, bool $detalhes = false): array
    {
        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        $results = DB::table('contas as c')
            ->select(['c.*', 'b.nome', 'cc.nome as nomeCategoria'])
            ->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco')
            ->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id');

        if ($detalhes) {
            $results->where('c.id', '=', $id);
        } else {
            $results->where('c.data_termino_recorrente', '>=', $firstDayOfMonth)
                    ->where('c.data_termino_recorrente', '<=', $lastDayOfMonth)
                    ->whereIn('cc.categoria_id', [1,4]);
        }

        $results = $results->where('cc.secao', '=', 1)
            ->orderBy('c.data_termino_recorrente')
            ->get();

        return $results->toArray();
    }

    public function searchCreditos(int $id = null, bool $detalhes = false): array
    {
        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        $results = DB::table('creditos as c')
            ->select(['c.*', 'b.nome', 'cc.nome as nomeCategoria'])
            ->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco')
            ->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id');

        if ($detalhes) {
            $results->where('c.id', '=', $id);
        } else {
            $results->where('c.data_termino_recorrente', '>=', $firstDayOfMonth)
                    ->where('c.data_termino_recorrente', '<=', $lastDayOfMonth)
                    ->whereIn('cc.categoria_id', [1,2]);
        }

        $results = $results->where('cc.secao', '=', 2)
            ->orderBy('c.data_termino_recorrente')
            ->get();

        return $results->toArray();
    }

    public function getBancos(): array
    {
        $results = DB::table('bancos as b')->get();

        return $results->toArray();
    }

    public function getCategorias(int $secao): array
    {
        $results = DB::table('categorias')
            ->where('secao', $secao)
            ->get();

        return $results->toArray();
    }

    public function saveConta(array $conta)
    {
        $data = [
            'data' => $conta['data'],
            'descricao' => ucwords(strtolower($conta['descricao'])),
            'valor' => $conta['valor'],
            'recorrente' => $conta['recorrente'],
            'data_termino_recorrente' => $conta['data_termino_recorrente'],
            'status' => $conta['status'],
            'banco' => $conta['banco'],
            'categoria' => $conta['categoria'],
        ];

        $id = (int)$conta['id'];

        if ($id === 0) {
            $insertedId = DB::table('contas')->insertGetId($data);

            $conta['id'] = $insertedId;
            $this->saveContaHistorico($conta);
        } else {
            $this->updateConta($conta);
        }
    }

    public function saveContaHistorico(array $conta)
    {
        $data = [
            'data' => $conta['data'],
            'descricao' => ucwords(strtolower($conta['descricao'])),
            'valor' => $conta['valor'],
            'recorrente' => $conta['recorrente'],
            'data_termino_recorrente' => $conta['data_termino_recorrente'],
            'status' => $conta['status'],
            'banco' => $conta['banco'],
            'categoria' => $conta['categoria'],
        ];

        DB::table('contasHistorico')->insert($data);
    }

    private function updateConta(array $conta)
    {
        $data = [
            'data' => $conta['data'],
            'descricao' => ucwords(strtolower($conta['descricao'])),
            'valor' => $conta['valor'],
            'recorrente' => $conta['recorrente'],
            'data_termino_recorrente' => $conta['data_termino_recorrente'],
            'status' => $conta['status'],
            'banco' => $conta['banco'],
            'categoria' => $conta['categoria'],
        ];

        $id = (int) $conta['id'];

        $updated = DB::table('contas')->where('id', $id)->update($data);

        if ($updated) {
            $this->saveContaHistorico($conta);
        } else {
            throw new \Exception('Conta não encontrada.');
        }
    }

    public function getConta(int $id)
    {
        $results = DB::table('contas as c')
            ->where('c.id','=', $id)
            ->first();

        return $results;
    }

    public function deleteConta(int $id)
    {
        return DB::table('contas')->where('id', $id)->delete();
    }

    public function saveCredito(array $credito)
    {
        $data = [
            'data' => $credito['data'],
            'descricao' => ucwords(strtolower($credito['descricao'])),
            'valor' => $credito['valor'],
            'recorrente' => $credito['recorrente'],
            'data_termino_recorrente' => $credito['data_termino_recorrente'],
            'status' => $credito['status'],
            'banco' => $credito['banco'],
            'categoria' => $credito['categoria'],
        ];

        $id = (int)$credito['id'];

        if ($id === 0) {
            $insertedId = DB::table('creditos')->insertGetId($data);

            $credito['id'] = $insertedId;
            $this->saveCreditoHistorico($credito);
        } else {
            $this->updateCredito($credito);
        }
    }

    public function saveCreditoHistorico(array $credito)
    {
        $data = [
            'data' => $credito['data'],
            'descricao' => ucwords(strtolower($credito['descricao'])),
            'valor' => $credito['valor'],
            'recorrente' => $credito['recorrente'],
            'data_termino_recorrente' => $credito['data_termino_recorrente'],
            'status' => $credito['status'],
            'banco' => $credito['banco'],
            'categoria' => $credito['categoria'],
        ];

        DB::table('creditosHistorico')->insert($data);
    }

    private function updateCredito(array $credito)
    {
        $data = [
            'data' => $credito['data'],
            'descricao' => ucwords(strtolower($credito['descricao'])),
            'valor' => $credito['valor'],
            'recorrente' => $credito['recorrente'],
            'data_termino_recorrente' => $credito['data_termino_recorrente'],
            'status' => $credito['status'],
            'banco' => $credito['banco'],
            'categoria' => $credito['categoria'],
        ];

        $id = (int) $credito['id'];

        $updated = DB::table('creditos')->where('id', $id)->update($data);

        if ($updated) {
            $this->saveCreditoHistorico($credito);
        } else {
            throw new \Exception('Crédito não encontrado.');
        }
    }

    public function getCredito(int $id)
    {
        $results = DB::table('creditos as c')
            ->where('c.id','=', $id)
            ->first();

        return $results;
    }

    public function deleteCredito(int $id)
    {
        return DB::table('creditos')->where('id', $id)->delete();
    }

    public function getListadoContas(array $formData): array
    {
        $results = DB::table('contasHistorico as c');
        $results->select(['c.*', 'b.nome', 'cc.nome as nomeCategoria']);

        if ($formData['dataFim']) {
            $results->whereBetween('data_termino_recorrente', [$formData['dataDesde'], $formData['dataFim']]);
        } else {
            $results->where('data_termino_recorrente', $formData['dataDesde']);
        }

        if ($formData['valor']) {
            $valorString = strval($formData['valor']);
            $results->where('c.valor', 'like', '%' . $valorString . '%');
        }
        if ($formData['recorrente']) {
            $results->where('c.recorrente', '=', $formData['recorrente']);
        }
        if ($formData['banco']) {
            $results->where('c.banco', '=', $formData['banco']);
        }
        if ($formData['categoria']) {
            $results->where('c.categoria', '=', $formData['categoria']);
        }
        $results->where('cc.secao', '=', 1);
        $results->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco');
        $results->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id');

        $results->orderBy('data_termino_recorrente');

        return $results->get()->toArray();
    }

    public function getListadoCreditos(array $formData): array
    {
        $results = DB::table('creditosHistorico as c');
        $results->select(['c.*', 'b.nome', 'cc.nome as nomeCategoria']);

        if ($formData['dataFim']) {
            $results->whereBetween('data_termino_recorrente', [$formData['dataDesde'], $formData['dataFim']]);
        } else {
            $results->where('data_termino_recorrente', $formData['dataDesde']);
        }

        if ($formData['valor']) {
            $valorString = strval($formData['valor']);
            $results->where('c.valor', 'like', '%' . $valorString . '%');
        }
        if ($formData['recorrente']) {
            $results->where('c.recorrente', '=', $formData['recorrente']);
        }
        if ($formData['banco']) {
            $results->where('c.banco', '=', $formData['banco']);
        }
        if ($formData['categoria']) {
            $results->where('c.categoria', '=', $formData['categoria']);
        }
        $results->where('cc.secao', '=', 2);
        $results->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco');
        $results->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id');

        $results->orderBy('data_termino_recorrente');
        // dd($results->toSql());
        return $results->get()->toArray();
    }

    public function searchContasCreditosData(string $tabela, bool $isCount = false)
    {
        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        $results = DB::table($tabela.' as c')
            ->select(['c.*', 'b.nome as nomeBanco', 'cc.nome as nomeCategoria'])
            ->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco')
            ->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id')
            ->where('c.data_termino_recorrente', '>=', $firstDayOfMonth)
            ->where('c.data_termino_recorrente', '<=', $lastDayOfMonth)
            ->when($tabela === 'contas', function ($query) {
                return $query->where('cc.secao', '=', 1);
            })
            ->when($tabela === 'creditos', function ($query) {
                return $query->where('cc.secao', '=', 2);
            })
            ->orderBy('c.data_termino_recorrente');

        return $results->get();
    }

    public function countContasCreditos(string $tabela)
    {
        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        $count = DB::table($tabela.' as c')
            ->where('c.recorrente', 1)
            ->where(function($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                $query->where('c.data_termino_recorrente', '>=', $firstDayOfMonth)
                    ->where('c.data_termino_recorrente', '<=', $lastDayOfMonth);
            })
            ->orWhere(function($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                $query->where('c.recorrente', 0)
                    ->where('c.data', '>=', $firstDayOfMonth)
                    ->where('c.data', '<=', $lastDayOfMonth);
            })
            ->count();

        return $count;
    }
}

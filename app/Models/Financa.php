<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Financa extends Model
{

    public function searchBillings(int $id = null, bool $detalhes = false): array
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        $results = DB::table('contas as c')
            ->select(['c.*', 'b.nome', 'cc.nome as nomeCategoria'])
            ->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco')
            ->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id');

        if ($detalhes) {
            $results->where('c.id', '=', $id);
        } else {
            $results->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                $query->whereBetween('c.data_termino_recorrente', [$firstDayOfMonth, $lastDayOfMonth]);
            });
        }
        $results = $results->where('cc.secao', '=', 1)->where('cc.ativo', '!=', 0)->where('c.uid', '=', $uid)->orderBy('c.vencimento')->get();
        return $results->toArray();
    }

    public function searchCreditos(int $id = null, bool $detalhes = false): array
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        $results = DB::table('creditos as c')
            ->select(['c.*', 'b.nome', 'cc.nome as nomeCategoria'])
            ->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco')
            ->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id');

        if ($detalhes) {
            $results->where('c.id', '=', $id);
        } else {
            $results->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                $query->whereBetween('c.data_termino_recorrente', [$firstDayOfMonth, $lastDayOfMonth]);
            });
        }
        $results = $results->where('cc.secao', '=', 2)->where('cc.ativo', '!=', 0)->where('c.uid', '=', $uid)->orderBy('c.data_termino_recorrente')->get();
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
            ->where('ativo', '!=', 0)
        ->get();
        return $results->toArray();
    }

    public function saveConta(array $conta)
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $data = [
            'uid' => $uid,
            'data' => $conta['data'],
            'descricao' => ucwords(strtolower($conta['descricao'])),
            'valor' => $conta['valor'],
            'recorrente' => $conta['recorrente'],
            'data_termino_recorrente' => $conta['data_termino_recorrente'],
            'status' => $conta['status'],
            'banco' => $conta['banco'],
            'categoria' => $conta['categoria'],
            'vencimento' => $conta['vencimento'],
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
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $data = [
            'uid' => $uid,
            'data' => $conta['data'],
            'descricao' => ucwords(strtolower($conta['descricao'])),
            'valor' => $conta['valor'],
            'recorrente' => $conta['recorrente'],
            'data_termino_recorrente' => $conta['data_termino_recorrente'],
            'status' => $conta['status'],
            'banco' => $conta['banco'],
            'categoria' => $conta['categoria'],
            'vencimento' => $conta['vencimento'],
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
            'vencimento' => $conta['vencimento'],
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
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $data = [
            'uid' => $uid,
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
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $data = [
            'uid' => $uid,
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
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

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
        $results->where('cc.secao', '=', 1)->where('c.uid', '=', $uid);
        $results->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco');
        $results->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id');

        $results->orderBy('data_termino_recorrente');
        return $results->get()->toArray();
    }

    public function getListadoCreditos(array $formData): array
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

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
        $results->where('cc.secao', '=', 2)->where('c.uid', '=', $uid);
        $results->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco');
        $results->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id');

        $results->orderBy('data_termino_recorrente');
        return $results->get()->toArray();
    }

    public function searchContasCreditosData(string $tabela)
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        $results = DB::table($tabela.' as c')
            ->select(['c.*', 'b.nome as nomeBanco', 'cc.nome as nomeCategoria'])
            ->leftJoin('bancos as b', 'c.banco', '=', 'b.id_banco')
            ->leftJoin('categorias as cc', 'c.categoria', '=', 'cc.categoria_id')
            ->where('c.uid', '=', $uid)
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
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        $count = DB::table($tabela.' as c')
            ->where('c.uid', '=', $uid)
            ->where(function($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                $query->where('c.recorrente', 1)
                    ->where('c.data_termino_recorrente', '>=', $firstDayOfMonth)
                    ->where('c.data_termino_recorrente', '<=', $lastDayOfMonth);
            })
            ->orWhere(function($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                $query->where('c.recorrente', 2)
                    ->where('c.data', '>=', $firstDayOfMonth)
                    ->where('c.data', '<=', $lastDayOfMonth);
            })
        ->count();
        return $count;
    }

    public static function obterContasPorVencimentoEStatus($dataVencimento)
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $registros = DB::table('contas')
            ->where('vencimento', '=', $dataVencimento)
            ->where('uid', '=', $uid)
            ->where('status', '=', 1)
        ->get();
        return $registros;
    }

    public function searchNubankCreditos()
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        // Realiza a consulta na tabela de contas
        $contasBanco = DB::table('contas')
            ->where('descricao', 'like', '%BANK%')
            ->where('uid', '=', $uid)
            ->whereBetween('data_termino_recorrente', [$firstDayOfMonth, $lastDayOfMonth])
            ->get()
        ->toArray();

        // Calcula a soma do valor da coluna 'valor' para a tabela de contas
        $somaContas = array_sum(array_column($contasBanco, 'valor'));

        // Realiza a consulta na tabela de creditos onde banco = 2
        $creditosBanco2 = DB::table('creditos')
            ->where('banco', '=', 2)
            ->where('uid', '=', $uid)
            ->whereBetween('data_termino_recorrente', [$firstDayOfMonth, $lastDayOfMonth])
            ->get()
        ->toArray();

        // Calcula a soma do valor da coluna 'valor' para a tabela de creditos
        $somaCreditos = array_sum(array_column($creditosBanco2, 'valor'));
        return $somaContas + $somaCreditos;
    }

    public function getTotalMes()
    {
        $mesPassado = Carbon::now()->subMonth()->format('Y-m');
        return DB::table('totalMes')
            ->where('mes_referencia', '=', $mesPassado)
        ->first();
    }

    public function getTotalMesAtual()
    {
        $mesAtual = Carbon::now()->format('Y-m');
        return DB::table('totalMes')
            ->where('mes_referencia', '=', $mesAtual)
        ->value('total_mes');
    }

    public function calcularSaldoMes()
    {
        $firstDayOfMonth = now()->startOfMonth()->toDateString();
        $lastDayOfMonth = now()->endOfMonth()->toDateString();

        $creditos = DB::table('creditos')->whereBetween('data_termino_recorrente', [$firstDayOfMonth, $lastDayOfMonth])->sum('valor');
        $contas = DB::table('contas')->whereBetween('data_termino_recorrente', [$firstDayOfMonth, $lastDayOfMonth])->sum('valor');

        $saldo = $creditos - $contas;
        $saldoFormatado = number_format($saldo, 2, '.', '');
        return $saldoFormatado;
    }

    public function salvarSaldoTotalMes($saldo)
    {
        $mesReferencia = now()->format('Y-m');
        return DB::table('totalMes')->updateOrInsert(
            ['mes_referencia' => $mesReferencia],
            ['total_mes' => $saldo, 'created_at' => now()]
        );
    }
}

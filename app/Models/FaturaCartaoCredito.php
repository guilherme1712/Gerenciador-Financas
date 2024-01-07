<?php

// Em app/Models/FaturaCartaoCredito.php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FaturaCartaoCredito
{
    public static function criarFatura()
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $ultimaFatura = DB::table('faturas_cartao_credito')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$ultimaFatura) {
            return 0;
        }

        $hoje = now();
        $dataVencimento = Carbon::parse($hoje->format('Y-m-') . $ultimaFatura->dia_vencimento);
        $dataFechamento = Carbon::parse($hoje->format('Y-m-') . $ultimaFatura->dia_fechamento);

        if ($hoje->between($dataVencimento, $dataFechamento)) {
            $mesReferenciaProximaFatura = $hoje->addMonth()->format('Y-m');

            $dataFechamentoProximaFatura = $ultimaFatura->dia_fechamento;

            return DB::table('faturas_cartao_credito')->insertGetId([
                'uid' => $uid,
                'mes_referencia' => $mesReferenciaProximaFatura,
                'valor' => 0,
                'dia_fechamento' => $dataFechamentoProximaFatura,
                'dia_vencimento' => $ultimaFatura->dia_vencimento,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return 0;
    }

    public static function atualizarFatura($id, $valor, $status)
    {
        return DB::table('faturas_cartao_credito')
            ->where('id', $id)
            ->update([
                'valor' => $valor,
                'status' => $status,
                'updated_at' => now(),
            ]);
    }

    public static function excluirFatura($id)
    {
        return DB::table('faturas_cartao_credito')->where('id', $id)->delete();
    }

    public static function obterInformacoesFatura($id)
    {
        return DB::table('faturas_cartao_credito')->find($id);
    }

    public function getAllFaturas()
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        return DB::table('faturas_cartao_credito')->where('uid', '=', $uid)->get();
    }

    public function salvarManualmente($valor, $diaVencimento, $mesReferencia, $status)
    {
        $uid = DB::table('users')
            ->where('email', '=', Session::get('userEmail'))
        ->value('id');

        $dataCompleta = date('Y-m', strtotime($mesReferencia)) . '-' . $diaVencimento;
        $diaVencimentoCarbon = Carbon::parse($dataCompleta);
        $dataFechamento = $diaVencimentoCarbon->subDays(7)->format('d');

        return DB::table('faturas_cartao_credito')->insertGetId([
            'uid' => $uid,
            'mes_referencia' => $mesReferencia ?? now()->addMonth()->format('Y-m'),
            'valor' => $valor,
            'dia_fechamento' => $dataFechamento,
            'dia_vencimento' => $diaVencimento,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function getFaturaMesAtual()
    {
        $results = DB::table('faturas_cartao_credito')
            ->where('mes_referencia', '=', now()->format('Y-m'));

        return $results->get();
    }
}

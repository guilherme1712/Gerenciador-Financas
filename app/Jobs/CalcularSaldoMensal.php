<?php

namespace App\Jobs;

use App\Models\Financa;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CalcularSaldoMensal implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $financa = new Financa();
        try {
            $saldo = $financa->calcularSaldoMes();
            $financa->salvarSaldoNoTotalMes($saldo);

            // Utiliza o saldo no início do próximo mês (exemplo)
            // Substitua esta parte com a lógica real de utilização do saldo no novo mês
            // Pode envolver transações, ajustes, etc.
            $saldoProximoMes = $saldo;
            Log::info("Job " . self::class . "executado às " . now()->toTimeString().". Saldo para o próximo mês: $saldoProximoMes");
        } catch (\Exception $e) {
            Log::error('Erro ao executar job CalcularSaldoMensal: ' . $e->getMessage());
        }
    }
}

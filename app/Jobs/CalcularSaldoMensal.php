<?php

namespace App\Jobs;

use App\Models\Financa;
use App\Models\JobEstado;
use Illuminate\Bus\Queueable;
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

            JobEstado::create(['executado' => true, 'created_at' => now(), 'jobname' => self::class]);
            $saldoProximoMes = $saldo;
            Log::info("Job " . self::class . "executado às " . now()->toTimeString().". Saldo para o próximo mês: $saldoProximoMes");
        } catch (\Exception $e) {
            Log::error("Erro ao executar job " . self::class . $e->getMessage());
        }
    }
}
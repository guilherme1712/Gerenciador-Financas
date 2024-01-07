<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Financa;
use App\Models\JobEstado;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
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
        $user = new User();

        try {
            $uid = $user->getUid(Redis::get('userEmail'));
            $saldoMesAtual = $financa->getTotalMesAtual();
            $saldo = $financa->calcularSaldoMes($uid);

            if ($saldo != $saldoMesAtual) {
                $financa->salvarSaldoTotalMes($saldo);

                JobEstado::create(['executado' => true, 'created_at' => now(), 'jobname' => self::class]);
                Log::info("Job " . self::class . " executado às " . now()->toTimeString().". Saldo para o próximo mês: $saldo. uid: $uid");
            }
        } catch (\Exception $e) {
            Log::error("Erro ao executar job " . self::class . $e->getMessage());
        }
    }
}
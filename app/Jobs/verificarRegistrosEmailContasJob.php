<?php

namespace App\Jobs;

use App\Models\JobEstado;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\FinancasController;

class verificarRegistrosEmailContasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    // public function handle()
    // {
    //     $financasController = new FinancasController();
    //     $resultadoVerificacao = $financasController->verificarRegistrosEmailContas();

    //     // Log ou qualquer ação que você queira realizar
    //     Log::info('Job verificarRegistrosEmailContasEmailContasJob executado. Resultado: ' . $resultadoVerificacao);
    // }

    public function handle()
    {
        $now = now();
        $jobName = self::class;

        // Verifique se o job já foi executado hoje
        $todayExecutedJob = JobEstado::where('jobname', $jobName)
            ->whereDate('created_at', $now->toDateString())
            ->first();

        if (!$todayExecutedJob) {
            // Execute a lógica do job apenas na primeira chamada do dia
            $this->executeLogic($now, $jobName);

            // Crie um registro para indicar que o job foi executado
            JobEstado::create(['executado' => true, 'created_at' => $now, 'jobname' => $jobName]);
        } else {
            // Execute a lógica do job de hora em hora após a primeira execução
            $this->executeHourlyLogic($now, $jobName);
        }
    }

    /**
     * Execute a lógica do job.
     *
     * @param \Illuminate\Support\Carbon $now
     * @param string $jobName
     * @return void
     */
    private function executeLogic($now, $jobName)
    {
        // Lógica do job aqui
        $financasController = new FinancasController();
        $financasController->verificarRegistrosEmailContas();

        Log::info("Job $jobName executado às " . $now->toTimeString());
    }

    /**
     * Execute a lógica do job de hora em hora após a primeira execução.
     *
     * @param \Illuminate\Support\Carbon $now
     * @param string $jobName
     * @return void
     */
    private function executeHourlyLogic($now, $jobName)
    {
        if ($now->minute === 0) {
            // Lógica do job aqui (executada de hora em hora)
            $this->executeLogic($now, $jobName);
            Log::info("Job $jobName executado de hora em hora às " . $now->toTimeString());
        }
    }
}

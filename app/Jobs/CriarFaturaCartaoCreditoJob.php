<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use App\Models\FaturaCartaoCredito;
use App\Models\JobEstado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CriarFaturaCartaoCreditoJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $todayExecutedJob = JobEstado::where('jobname', self::class)
            ->whereDate('created_at', today())
            ->first();

        if (!$todayExecutedJob) {
            FaturaCartaoCredito::criarFatura();

            Log::info("Job " . self::class . "executado às " . now()->toTimeString());

            JobEstado::create(['executado' => true, 'created_at' => now(), 'jobname' => self::class]);
        }
    }
}

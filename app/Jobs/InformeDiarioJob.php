<?php

namespace App\Jobs;

use App\Models\JobEstado;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Controllers\EmailController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class InformeDiarioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

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
            $emailContrller = new EmailController();
            $emailContrller->enviarEmailInformeDiario();

            Log::info("Job " . self::class . "executado às " . now()->toTimeString());
            JobEstado::create(['executado' => true, 'created_at' => now(), 'jobname' => self::class]);
        }
    }
}

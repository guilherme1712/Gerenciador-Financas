<?php

namespace App\Console;

use App\Jobs\CriarFaturaCartaoCreditoJob;
use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\verificarRegistrosEmailContasJob;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new verificarRegistrosEmailContasJob())->everyFiveMinutes();
        $schedule->job(new CriarFaturaCartaoCreditoJob())->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

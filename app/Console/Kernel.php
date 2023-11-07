<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('deshabilitar_fechas')->hourly(); // Programa la ejecución diaria de tu comando
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        // $this->commands([
        //     \App\Console\Commands\deshabilitar_fechas::class,
        // ]);

        require base_path('routes/console.php');
    }
}

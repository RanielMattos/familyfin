<?php

namespace App\Console;

use App\Console\Commands\GenerateBillOccurrences;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Commands registrados explicitamente.
     */
    protected $commands = [
        GenerateBillOccurrences::class,
    ];

    /**
     * Agenda de execução (opcional).
     */
    protected function schedule(Schedule $schedule): void
    {
        // Quando você quiser automatizar:
        // $schedule->command('planpag:generate')->dailyAt('03:00');
    }

    /**
     * Carrega commands e rotas de console.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

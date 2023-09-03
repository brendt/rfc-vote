<?php

namespace App\Console;

use App\Console\Commands\RfcSyncCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @codeCoverageIgnore part of Laravel framework, no need to test
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(RfcSyncCommand::class)->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

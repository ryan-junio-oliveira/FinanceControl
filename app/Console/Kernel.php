<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\PurgeArchivedOrganizations::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // daily purge of archived organizations
        $schedule->command('organizations:purge-archived')->daily();
    }

    protected function commands(): void
    {
        // load default commands if any
    }
}

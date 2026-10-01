<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        // Other commands...
        \App\Console\Commands\CheckBibleWords::class,
        \App\Console\Commands\VerseImportCronJob::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Run verse import processing every minute
        $schedule->command('verse:import-process')
                    ->everyMinute()
                    ->appendOutputTo(storage_path('logs/verse-import-cron.log'));
        
        // Run bible words processing every minute
        $schedule->command('bible:check-words')->everyMinute();

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

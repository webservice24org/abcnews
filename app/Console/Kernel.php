<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // This will run your command every minute
        $schedule->command('news:publish-scheduled')->everyMinute();
    }
    protected $commands = [
        \App\Console\Commands\TransliterateDistrictSlugs::class,
        \App\Console\Commands\GenerateLicense::class,
    ];


    protected function commands(): void
    {
        // Load custom Artisan commands
        $this->load(__DIR__.'/Commands');

        // Load additional console routes if needed
        require base_path('routes/console.php');
       
    }
    
    

}


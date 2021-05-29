<?php

namespace App\Console;

use App\Console\Commands\SendNewsLetterCommand;
use App\Console\Commands\SendEmailVerificationReminderCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendNewsLetterCommand::class,
        SendEmailVerificationReminderCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('inspire')
//            ->evenInMaintenanceMode()
//            ->sendOutputTo(storage_path('inspire.log'))
//            ->everyMinute();
//        $schedule->call(function () {
//           echo "Hola";
//        });
//        $schedule->call(function () {
//            echo "Hola";
//        })->everyFiveMinutes();

        $schedule->command(SendNewsLetterCommand::class)
            ->withoutOverlapping()
            ->onOneServer()
            ->mondays();

        $schedule->command(SendEmailVerificationReminderCommand::class)
            ->onOneServer()
            ->daily();
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

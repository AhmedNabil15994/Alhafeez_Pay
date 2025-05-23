<?php

namespace App\Console;

use Modules\Core\Console\CreateCrudes;
use Modules\Apps\Console\AppSetupCommand;
use App\Console\Commands\CreatePermission;
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
        AppSetupCommand::class ,
        CreatePermission::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('expires:tokens')->everyFiveMinutes();
        // if (\App::environment('production') && config("backup.allow")) {
        //     $schedule->command('backup:clean')->daily()->at('01:00');
        //     $schedule->command('backup:run')->daily()->at('02:00');
        // }

        // if (config("activitylog.run_clean", false)) {
        //     $schedule->command('activitylog:clean')->daily()->at('01:00');
        // }
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

    protected function bootstrappers()
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}

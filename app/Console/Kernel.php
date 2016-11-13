<?php

namespace App\Console;

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
        Commands\TweetQuote::class,
        Commands\PromoteWebsite::class,
        Commands\FollowUsers::class,
        Commands\UnfollowUsers::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Post quotes
        $schedule->command('tq:post-quote')->cron('20 */2 * * * *');
        $schedule->command('tq:post-quote')->cron('40 3,11,17 * * * *');

        // Promote the website
        $schedule->command('tq:promote')->cron('10 6,18 * * * *');

        // Follow users
        $schedule->command('tq:follow-users')->cron('21 */2 * * * *');
        // Unfollow users
        $schedule->command('tq:unfollow-users')->cron('10 */2 * * * *');
    }
}

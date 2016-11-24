<?php

namespace App\Console\Commands;

use App\TwitterUtils;
use Illuminate\Console\Command;
use Twitter;

class UnfollowUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tq:unfollow-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unfollow users following me';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $toUnfollow = TwitterUtils::myFollowings(rand(10, 15));

        $toUnfollow->each(function($userId) {
            Twitter::postUnfollow(['user_id' => $userId]);
        });
    }
}

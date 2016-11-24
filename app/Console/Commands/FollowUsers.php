<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twitter;
use App\TwitterUtils;

class FollowUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tq:follow-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Follow users following @ohteenquotes';

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
        $myFollowers = TwitterUtils::myFollowers();
        $usersToFollow = TwitterUtils::followersForAccount('ohteenquotes', rand(25, 50));
        $alreadyRequested = $this->alreadyRequested($usersToFollow);

        // We should follow:
        // - users following @ohteenquotes
        // - that we don't already follow
        // - that we didn't already requested to follow
        $toFollow = $usersToFollow->diff($myFollowers)->diff($alreadyRequested);

        $toFollow->each(function($userId) {
            Twitter::postFollow(['user_id' => $userId]);
        });
    }

    private function alreadyRequested($users)
    {
        $res = collect(Twitter::getFriendshipsLookup(['user_id' => $users->implode(',')]));

        return $res->filter(function($el) {
            return in_array("following_requested", $el->connections);
        })->map(function($el) {
            return $el->id;
        });
    }
}

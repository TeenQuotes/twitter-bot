<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Twitter;

class PromoteWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tq:promote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post a promotion for the website to Twitter';

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
        $randomContent = $this->getRandomPromotion();

        Twitter::postTweet(['status' => htmlspecialchars_decode($randomContent), 'format' => 'json']);
    }

    private function getRandomPromotion()
    {
        $c = new Collection([
            'Got some time and want to be inspired? Check out random quotes! http://teen-quotes.com/random',
            'Check out the best quotes ever published on Teen Quotes: http://teen-quotes.com/top/favorites',
            'Feeling inspired? Ready to inspire others? Create an account! https://account.teen-quotes.com/signup',
            "It's a beautiful day to browse the latest published quotes on Teen Quotes! http://teen-quotes.com #love #life",
            'Want to post quotes? Save quotes to your favorites? Have a personal profile? Create an account! https://account.teen-quotes.com/signup',
            ]);

        return $c->random();
    }
}

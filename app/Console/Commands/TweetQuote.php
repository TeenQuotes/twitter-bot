<?php

namespace App\Console\Commands;

use App\Quote;
use Illuminate\Console\Command;
use Twitter;

class TweetQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tq:post-quote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post a quote from the database to Twitter';

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
        $quote = Quote::published()->inTwitterSize()->random()->first();
        Twitter::postTweet(['status' => htmlspecialchars_decode($quote->content), 'format' => 'json']);
    }
}

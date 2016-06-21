<?php

use App\Quote;

Route::get('/', function()
{
    return Quote::published()->inTwitterSize()->random()->first();
    // return Twitter::postTweet(['status' => 'Hello World', 'format' => 'json']);
});

<?php

namespace App;

use Twitter;

class TwitterUtils
{
    public static function followersForAccount($screenName, $limit=5000)
    {
        $response = Twitter::getFollowersIds(['screen_name' => $screenName, 'count' => $limit]);

        return collect($response->ids);
    }

    public static function followingsForAccount($screenName, $limit=5000)
    {
        $response = Twitter::getFriendsIds(['screen_name' => $screenName, 'count' => $limit]);

        return collect($response->ids);
    }

    public static function myFollowers($limit=5000)
    {
        return self::followersForAccount(config('services.twitter.my_screen_name'), $limit);
    }

    public static function myFollowings($limit=5000)
    {
        return self::followingsForAccount(config('services.twitter.my_screen_name'), $limit);
    }
}

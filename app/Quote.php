<?php

namespace App;

use DB;
use Config;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    const REFUSED = -1;
    const WAITING = 0;
    const PUBLISHED = 1;
    const PENDING = 2;

    protected $fillable = ['id', 'content'];

    /**
     * Scope a query to only include published quotes.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('approved', '=', self::PUBLISHED);
    }

    public function scopeInTwitterSize($query)
    {
        return $query->whereRaw('char_length(content) <= '.Config::get('twitter.tweetSize'));
    }

    /**
     * Get random quotes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRandom($query)
    {
        return $query->orderBy(DB::raw('RAND()'));
    }
}

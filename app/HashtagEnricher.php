<?php

namespace App;

use Illuminate\Support\Collection;

class HashtagEnricher extends Enricher
{
    private $hashtags = ['school', 'family', 'love', 'friends', 'holiday', 'music', 'book',
        'crush', 'awkward', 'remember', 'distance', 'stars', 'phone', 'smartphone',
        'tears', 'cheating', 'smile', 'summer', 'winter', 'spring', 'heart', 'bullshit',
        'mistake', 'story', 'grow', 'kiss', 'memories', 'confused', 'messages', 'boyfriend',
        'girlfriend', 'pray', 'song', 'dad', 'mum', 'moon', ];

    /**
     * Enrich the content of a quote.
     *
     * @param Quote $q
     *
     * @return Quote
     */
    protected function enrich(Quote $q)
    {
        $hashtags = $this->eligibleHashtags($q)->shuffle();

        foreach ($hashtags as $hashtag) {
            if ($this->hashtagFitsInQuote($hashtag, $q)) {
                $q->content = sprintf('%s #%s', $q->content, $hashtag);
            }
        }

        return $q;
    }

    /**
     * Should the enricher try to enrich the quote?
     *
     * @return bool
     */
    protected function shouldAct()
    {
        return $this->generator->generate(100) <= 70;
    }

    /**
     * Can the enricher actually modify the content of the quote?
     *
     * @param Quote $q
     *
     * @return bool
     */
    protected function canAct(Quote $q)
    {
        return $this->eligibleHashtags($q)->count() > 0;
    }

    private function eligibleHashtags(Quote $q)
    {
        return (new Collection($this->hashtags))->filter(function ($hashtag) use ($q) {
            $containsHastag = $this->str_contains(strtolower($q->content), $hashtag);
            $sizeFits = $this->hashtagFitsInQuote($hashtag, $q);

            return $containsHastag and $sizeFits;
        });
    }

    private function hashtagFitsInQuote($hashtag, Quote $q)
    {
        // 1 for whitespace
        // 1 for #
        // 140 is the size of a tweet
        return (strlen($q->content) + strlen($hashtag) + 2) <= 140;
    }

    private function str_contains($str, $search)
    {
        return strpos($str, $search) !== false;
    }
}

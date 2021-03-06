<?php

namespace App;

class LinkEnricher extends Enricher
{
    /**
     * Enrich the content of a quote.
     *
     * @param Quote $q
     *
     * @return Quote
     */
    protected function enrich(Quote $q)
    {
        $q->content = sprintf('%s http://teen-quotes.com/quotes/%s', $q->content, $q->id);

        return $q;
    }

    /**
     * Should the enricher try to enrich the quote?
     *
     * @return bool
     */
    protected function shouldAct()
    {
        return $this->generator->generate(100) <= 25;
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
        // A URL of any length will be altered to 23 characters https://support.twitter.com/articles/78124
        // 1 for whitespace
        return (strlen($q->content) + 23 + 1) <= $this->tweetSize();
    }
}

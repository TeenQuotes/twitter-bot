<?php

namespace App;

use Config;

abstract class Enricher
{
    /**
     * @var RandomGeneratorInterface
     */
    protected $generator;

    public function __construct(RandomGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    final public function act(Quote $q)
    {
        if ($this->shouldAct() and $this->canAct($q)) {
            return $this->enrich($q);
        }

        return $q;
    }

    /**
     * Enrich the content of a quote.
     *
     * @param Quote $q
     *
     * @return Quote
     */
    abstract protected function enrich(Quote $q);

    /**
     * Should the enricher try to enrich the quote?
     *
     * @return bool
     */
    abstract protected function shouldAct();

    /**
     * Can the enricher actually modify the content of the quote?
     *
     * @param Quote $q
     *
     * @return bool
     */
    abstract protected function canAct(Quote $q);

    protected function tweetSize()
    {
        return Config::get('twitter.tweetSize');
    }
}

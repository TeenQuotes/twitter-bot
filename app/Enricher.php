<?php

namespace App;

abstract class Enricher {

    /**
     * @var RandomGeneratorInterface
     */
    protected $generator;

    public function __construct(RandomGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public final function act(Quote $q)
    {
        if ($this->shouldAct() and $this->canAct($q)) {
            return $this->enrich($q);
        }
        return $q;
    }

    /**
     * Enrich the content of a quote.
     * @param  Quote  $q
     * @return Quote
     */
    protected abstract function enrich(Quote $q);

    /**
     * Should the enricher try to enrich the quote?
     * @return bool
     */
    protected abstract function shouldAct();

    /**
     * Can the enricher actually modify the content of the quote?
     * @param  Quote  $q
     * @return bool
     */
    protected abstract function canAct(Quote $q);
}

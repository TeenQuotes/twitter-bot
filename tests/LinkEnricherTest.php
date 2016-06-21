<?php

use App\RandomGeneratorInterface;
use App\LinkEnricher;
use App\Quote;

class LinkEnricherTest extends TestCase
{

    public function testEnrichQuoteWhenItCanAndGeneratorIsTrue()
    {
        $enricher = new LinkEnricher(new TrueResultRandomGenerator);
        $q = $this->fakeQuote();

        $this->assertEquals('foo http://teen-quotes.com/quotes/42', $enricher->act($q)->content);
    }

    public function testDoesNotEnrichQuoteWhenItCanAndGeneratorIsFalse()
    {
        $enricher = new LinkEnricher(new FalseResultRandomGenerator);
        $q = $this->fakeQuote();

        $this->assertEquals('foo', $enricher->act($q)->content);
    }

    public function testDoesNotEnrichQuoteWhenItCannotAndGeneratorIsTrue()
    {
        $enricher = new LinkEnricher(new TrueResultRandomGenerator);
        $content = str_repeat('a', 140 - 23);
        $q = $this->fakeQuote($content);

        $this->assertEquals($content, $enricher->act($q)->content);
    }

    private function fakeQuote($content = null)
    {
        $content = is_null($content) ? 'foo' : $content;

        return new Quote(['id' => 42, 'content' => $content]);
    }
}

class TrueResultRandomGenerator implements RandomGeneratorInterface {
    public function generate($upperBound)
    {
        return 24;
    }
}

class FalseResultRandomGenerator implements RandomGeneratorInterface {
    public function generate($upperBound)
    {
        return 26;
    }
}

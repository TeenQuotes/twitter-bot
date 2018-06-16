<?php

use App\LinkEnricher;
use App\Quote;
use App\RandomGenerator;

class LinkEnricherTest extends TestCase
{
    public function testEnrichQuoteWhenItCanAndGeneratorIsTrue()
    {
        $enricher = $this->trueLinkEnricher();
        $q = $this->fakeQuote();

        $this->assertEquals('foo http://teen-quotes.com/quotes/42', $enricher->act($q)->content);
    }

    public function testDoesNotEnrichQuoteWhenItCanAndGeneratorIsFalse()
    {
        $enricher = $this->falseLinkEnricher();
        $q = $this->fakeQuote();

        $this->assertEquals('foo', $enricher->act($q)->content);
    }

    public function testDoesNotEnrichQuoteWhenItCannotAndGeneratorIsTrue()
    {
        $enricher = $this->trueLinkEnricher();
        $content = str_repeat('a', Config::get('twitter.tweetSize') - 23);
        $q = $this->fakeQuote($content);

        $this->assertEquals($content, $enricher->act($q)->content);
    }

    private function fakeQuote($content = null)
    {
        $content = is_null($content) ? 'foo' : $content;

        return new Quote(['id' => 42, 'content' => $content]);
    }

    private function trueLinkEnricher()
    {
        $generator = $this->prophesize(RandomGenerator::class);

        $generator->generate(100)->shouldBeCalled()->willReturn(25);

        return new LinkEnricher($generator->reveal());
    }

    private function falseLinkEnricher()
    {
        $generator = $this->prophesize(RandomGenerator::class);

        $generator->generate(100)->shouldBeCalled()->willReturn(26);

        return new LinkEnricher($generator->reveal());
    }
}

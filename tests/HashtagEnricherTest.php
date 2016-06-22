<?php

use App\HashtagEnricher;
use App\RandomGenerator;
use App\Quote;

class HashtagEnricherTest extends TestCase
{
    public function testEnrichQuoteWhenItCanAndGeneratorIsTrue()
    {
        $enricher = $this->trueHashtagEnricher();
        $q = $this->fakeQuote('Love is awesome!');

        $this->assertEquals('Love is awesome! #love', $enricher->act($q)->content);
    }

    public function testEnrichQuoteWithMultipleHashtagsWhenItCanAndGeneratorIsTrue()
    {
        $enricher = $this->trueHashtagEnricher();
        $q = $this->fakeQuote('I love, family and my friends!');

        $content = $enricher->act($q)->content;
        foreach (['#love', '#family', '#friends'] as $hashtag) {
            $this->assertContains($hashtag, $content);
        }
    }

    public function testDoesNotEnrichQuoteWhenItCanAndGeneratorIsFalse()
    {
        $enricher = $this->falseHashtagEnricher();
        $q = $this->fakeQuote('Love is awesome!');

        $this->assertEquals('Love is awesome!', $enricher->act($q)->content);
    }

    public function testDoesNotEnrichQuoteWhenItCannotAndGeneratorIsTrue()
    {
        $enricher = $this->trueHashtagEnricher();
        $content = 'love you!'.str_repeat('a', 140-strlen('love you! #love')+1);
        $q = $this->fakeQuote($content);

        $this->assertEquals($content, $enricher->act($q)->content);
    }

    private function fakeQuote($content = null)
    {
        $content = is_null($content) ? 'foo' : $content;

        return new Quote(['id' => 42, 'content' => $content]);
    }

    private function trueHashtagEnricher()
    {
        $generator = $this->prophesize(RandomGenerator::class);

        $generator->generate(100)->shouldBeCalled()->willReturn(70);

        return new HashtagEnricher($generator->reveal());
    }

    private function falseHashtagEnricher()
    {
        $generator = $this->prophesize(RandomGenerator::class);

        $generator->generate(100)->shouldBeCalled()->willReturn(71);

        return new HashtagEnricher($generator->reveal());
    }
}

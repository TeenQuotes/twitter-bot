<?php

namespace App;

class RandomGenerator implements RandomGeneratorInterface {

    /**
     * Generate a random integer between 1 and the upper bound (inclusive).
     * @param  int $upperBound
     * @return int
     */
    public function generate($upperBound)
    {
        return rand(1, $upperBound);
    }
}

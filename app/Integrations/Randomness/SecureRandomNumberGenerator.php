<?php

namespace App\Integrations\Randomness;

use App\Contracts\RandomNumberGenerator;

class SecureRandomNumberGenerator implements RandomNumberGenerator
{
    public function between(int $min, int $max): int
    {
        return random_int($min, $max);
    }
}

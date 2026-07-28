<?php

namespace App\Contracts;

interface RandomNumberGenerator
{
    public function between(int $min, int $max): int;
}

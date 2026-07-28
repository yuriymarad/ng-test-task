<?php

namespace App\Core\LuckyDraw;

class WinningAmountCalculator
{
    /**
     * @var list<array{int, int}>
     */
    private const TIERS = [
        [900, 70],
        [600, 50],
        [300, 30],
    ];

    private const BASE_PERCENTAGE = 10;

    public function calculate(int $number): float
    {
        foreach (self::TIERS as [$lowerBound, $percentage]) {
            if ($number > $lowerBound) {
                return $this->percentageOf($number, $percentage);
            }
        }

        return $this->percentageOf($number, self::BASE_PERCENTAGE);
    }

    private function percentageOf(int $number, int $percentage): float
    {
        return round($number * $percentage / 100, 2);
    }
}

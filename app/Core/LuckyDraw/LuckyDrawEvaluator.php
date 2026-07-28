<?php

namespace App\Core\LuckyDraw;

use App\Values\LuckyDrawOutcome;

class LuckyDrawEvaluator
{
    public function __construct(private WinningAmountCalculator $winningAmounts) {}

    public function evaluate(int $number): LuckyDrawOutcome
    {
        if ($number % 2 !== 0) {
            return LuckyDrawOutcome::lose($number);
        }

        return LuckyDrawOutcome::win($number, $this->winningAmounts->calculate($number));
    }
}

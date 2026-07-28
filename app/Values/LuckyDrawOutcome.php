<?php

namespace App\Values;

use App\Enums\LuckyDrawResult;

final class LuckyDrawOutcome
{
    private function __construct(
        public readonly int $number,
        public readonly LuckyDrawResult $result,
        public readonly float $amount,
    ) {}

    public static function win(int $number, float $amount): self
    {
        return new self($number, LuckyDrawResult::Win, $amount);
    }

    public static function lose(int $number): self
    {
        return new self($number, LuckyDrawResult::Lose, 0.0);
    }

    public function isWin(): bool
    {
        return $this->result === LuckyDrawResult::Win;
    }
}

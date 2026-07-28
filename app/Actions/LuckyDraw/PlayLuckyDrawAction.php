<?php

namespace App\Actions\LuckyDraw;

use App\Contracts\RandomNumberGenerator;
use App\Core\LuckyDraw\LuckyDrawEvaluator;
use App\Models\LuckyDraw;
use App\Models\Participant;

class PlayLuckyDrawAction
{
    private const MIN_NUMBER = 1;

    private const MAX_NUMBER = 1000;

    public function __construct(
        private RandomNumberGenerator $randomNumbers,
        private LuckyDrawEvaluator $evaluator,
    ) {}

    public function handle(Participant $participant): LuckyDraw
    {
        $number = $this->randomNumbers->between(self::MIN_NUMBER, self::MAX_NUMBER);

        $outcome = $this->evaluator->evaluate($number);

        return $participant->luckyDraws()->create([
            'number' => $outcome->number,
            'result' => $outcome->result,
            'amount' => $outcome->amount,
        ]);
    }
}

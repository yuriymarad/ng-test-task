<?php

namespace App\Http\Resources;

use App\Models\LuckyDraw;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin LuckyDraw
 */
class LuckyDrawResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number' => $this->number,
            'result' => $this->result->value,
            'amount' => (float) $this->amount,
            'createdAt' => $this->created_at?->toIso8601String(),
        ];
    }
}

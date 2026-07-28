<?php

namespace App\Models;

use App\Enums\LuckyDrawResult;
use Database\Factories\LuckyDrawFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['number', 'result', 'amount'])]
class LuckyDraw extends Model
{
    /** @use HasFactory<LuckyDrawFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'number' => 'integer',
            'result' => LuckyDrawResult::class,
            'amount' => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<Participant, $this>
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }
}

<?php

namespace App\Models;

use Database\Factories\ParticipantFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'phone'])]
class Participant extends Model
{
    /** @use HasFactory<ParticipantFactory> */
    use HasFactory;

    /**
     * @return HasMany<AccessLink, $this>
     */
    public function accessLinks(): HasMany
    {
        return $this->hasMany(AccessLink::class);
    }

    /**
     * @return HasMany<LuckyDraw, $this>
     */
    public function luckyDraws(): HasMany
    {
        return $this->hasMany(LuckyDraw::class);
    }

    /**
     * @return Collection<int, LuckyDraw>
     */
    public function recentDraws(int $limit): Collection
    {
        return $this->luckyDraws()
            ->latest('created_at')
            ->latest('id')
            ->limit($limit)
            ->get();
    }
}

<?php

namespace App\Models;

use Database\Factories\AccessLinkFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\RouteKey;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['token', 'expires_at'])]
#[RouteKey('token')]
class AccessLink extends Model
{
    /** @use HasFactory<AccessLinkFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'deactivated_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Participant, $this>
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    /**
     * @param  Builder<AccessLink>  $query
     */
    #[Scope]
    protected function usable(Builder $query): void
    {
        $query->whereNull('deactivated_at')->where('expires_at', '>', now());
    }

    public function isUsable(): bool
    {
        return $this->deactivated_at === null && $this->expires_at->isFuture();
    }

    public function deactivate(): void
    {
        $this->forceFill(['deactivated_at' => now()])->save();
    }

    /**
     * @param  mixed  $value
     * @param  string|null  $field
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->newQuery()
            ->usable()
            ->where($field ?? $this->getRouteKeyName(), $value)
            ->first();
    }
}

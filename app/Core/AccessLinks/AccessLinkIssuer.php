<?php

namespace App\Core\AccessLinks;

use App\Models\AccessLink;
use App\Models\Participant;
use Illuminate\Support\Str;

class AccessLinkIssuer
{
    public const LINK_LIFETIME_DAYS = 7;

    private const TOKEN_LENGTH = 64;

    public function issueFor(Participant $participant): AccessLink
    {
        $participant->accessLinks()
            ->whereNull('deactivated_at')
            ->update(['deactivated_at' => now()]);

        return $participant->accessLinks()->create([
            'token' => $this->generateUniqueToken(),
            'expires_at' => now()->addDays(self::LINK_LIFETIME_DAYS),
        ]);
    }

    private function generateUniqueToken(): string
    {
        do {
            $token = Str::random(self::TOKEN_LENGTH);
        } while (AccessLink::query()->where('token', $token)->exists());

        return $token;
    }
}

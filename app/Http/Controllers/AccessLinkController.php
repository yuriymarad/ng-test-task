<?php

namespace App\Http\Controllers;

use App\Actions\AccessLinks\DeactivateAccessLinkAction;
use App\Actions\AccessLinks\RegenerateAccessLinkAction;
use App\Http\Resources\LuckyDrawResource;
use App\Models\AccessLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AccessLinkController extends Controller
{
    private const HISTORY_SIZE = 10;

    public function show(Request $request, AccessLink $accessLink): Response
    {
        $participant = $accessLink->participant;

        return Inertia::render('lucky/link', [
            'participant' => [
                'name' => $participant->name,
            ],
            'link' => [
                'token' => $accessLink->token,
                'url' => route('access-link.show', $accessLink),
                'expiresAt' => $accessLink->expires_at->toIso8601String(),
            ],
            'lastDraw' => $request->session()->get('draw'),
            'history' => Inertia::optional(fn (): array => LuckyDrawResource::collection(
                $participant->recentDraws(self::HISTORY_SIZE),
            )->resolve()),
        ]);
    }

    public function regenerate(AccessLink $accessLink, RegenerateAccessLinkAction $action): RedirectResponse
    {
        $link = $action->handle($accessLink);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('A new link has been generated.')]);

        return to_route('access-link.show', $link);
    }

    public function destroy(AccessLink $accessLink, DeactivateAccessLinkAction $action): RedirectResponse
    {
        $action->handle($accessLink);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('The link has been deactivated.')]);

        return to_route('home');
    }
}

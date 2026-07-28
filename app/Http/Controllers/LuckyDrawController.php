<?php

namespace App\Http\Controllers;

use App\Actions\LuckyDraw\PlayLuckyDrawAction;
use App\Http\Resources\LuckyDrawResource;
use App\Models\AccessLink;
use Illuminate\Http\RedirectResponse;

class LuckyDrawController extends Controller
{
    public function store(AccessLink $accessLink, PlayLuckyDrawAction $action): RedirectResponse
    {
        $draw = $action->handle($accessLink->participant);

        return to_route('access-link.show', $accessLink)
            ->with('draw', LuckyDrawResource::make($draw)->resolve());
    }
}

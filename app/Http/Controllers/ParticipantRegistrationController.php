<?php

namespace App\Http\Controllers;

use App\Actions\Participants\RegisterParticipantAction;
use App\Data\RegisterParticipantData;
use App\Http\Requests\RegisterParticipantRequest;
use Illuminate\Http\RedirectResponse;

class ParticipantRegistrationController extends Controller
{
    public function store(RegisterParticipantRequest $request, RegisterParticipantAction $action): RedirectResponse
    {
        $link = $action->handle(RegisterParticipantData::fromRequest($request));

        return to_route('access-link.show', $link);
    }
}

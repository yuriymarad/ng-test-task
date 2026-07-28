<?php

namespace App\Actions\Participants;

use App\Core\AccessLinks\AccessLinkIssuer;
use App\Data\RegisterParticipantData;
use App\Models\AccessLink;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class RegisterParticipantAction
{
    public function __construct(private AccessLinkIssuer $accessLinks) {}

    public function handle(RegisterParticipantData $data): AccessLink
    {
        return DB::transaction(function () use ($data): AccessLink {
            $participant = Participant::query()->updateOrCreate(
                ['phone' => $data->phone->value],
                ['name' => $data->name],
            );

            return $this->accessLinks->issueFor($participant);
        });
    }
}

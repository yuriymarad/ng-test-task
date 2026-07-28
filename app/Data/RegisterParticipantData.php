<?php

namespace App\Data;

use App\Http\Requests\RegisterParticipantRequest;
use App\Values\PhoneNumber;

final class RegisterParticipantData
{
    public function __construct(
        public readonly string $name,
        public readonly PhoneNumber $phone,
    ) {}

    public static function fromRequest(RegisterParticipantRequest $request): self
    {
        return new self(
            name: $request->string('name')->trim()->value(),
            phone: PhoneNumber::fromInput($request->string('phone')->value()),
        );
    }
}

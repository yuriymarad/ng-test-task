<?php

namespace App\Values;

use InvalidArgumentException;

final class PhoneNumber
{
    private function __construct(public readonly string $value) {}

    // TODO: Implement proper phone number validation. The current validation is simplified for this test task.
    public static function fromInput(string $raw): self
    {
        $trimmed = trim($raw);
        $digits = preg_replace('/\D/', '', $trimmed) ?? '';

        if ($digits === '') {
            throw new InvalidArgumentException('A phone number must contain at least one digit.');
        }

        return new self(str_starts_with($trimmed, '+') ? '+'.$digits : $digits);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

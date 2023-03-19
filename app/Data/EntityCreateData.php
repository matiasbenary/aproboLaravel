<?php

namespace App\Data;

use Illuminate\Support\Str;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class EntityCreateData extends Data
{
    public function __construct(
        public string $business_name,
        public string $email,
        public int $cuit,
        public string $invitation_token,
        public string|Optional $fantasy_name,
        public int|Optional $cbu,
    ) {
    }

    public static function fromMultiple(
        string $business_name,
        string $email,
        int $cuit,
        string|Optional $fantasy_name,
        string|Optional $cbu
    ): self {
        $invitation_token = Str::uuid()->toString();
        return new self($business_name, $email, $cuit, $invitation_token, $fantasy_name ?? $business_name, $cbu);
    }

    public static function fromArray(
        array $data
    ): self {
        $invitation_token = Str::uuid()->toString();
        return new self($data['business_name'], $data['email'], $data['cuit'], $invitation_token, $data['fantasy_name'] ?? $data['business_name'], array_key_exists('cbu', $data) ?? null);
    }
}

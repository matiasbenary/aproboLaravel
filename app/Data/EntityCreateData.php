<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class EntityCreateData extends Data
{
    public function __construct(
        public string $business_name,
        public string $email,
        public int $cuit,
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
        return new self($business_name, $email, $cuit, $fantasy_name ?? $business_name, $cbu);
    }

    public static function fromArray(
        array $data
    ): self {
        return new self($data['business_name'], $data['email'], $data['cuit'], $data['fantasy_name'] ?? $data['business_name'], array_key_exists('cbu', $data) ?? null);
    }
}

<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class EntityData extends Data
{
    public function __construct(
        public int $id,
        public string $business_name,
        public string $email,
        public int $cuit,
        public string|Optional $invitation_token,
        public string|Optional $fantasy_name,
        public int|Optional|null $cbu,
    ) {
    }
}

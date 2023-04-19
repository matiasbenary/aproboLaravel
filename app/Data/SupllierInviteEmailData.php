<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;

class SupllierInviteEmailData extends Data
{
    public function __construct(
        #[Email]
        public string $email,
    ) {
    }
}

<?php

namespace App\Data\Supplier;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;

class InviteEmailSupllierData extends Data
{
    public function __construct(
        #[Email]
        public string $email,
    ) {
    }
}

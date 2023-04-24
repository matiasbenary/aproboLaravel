<?php

namespace App\Data\User;

use Spatie\LaravelData\Data;

/** @typescript */
class UserData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public bool $is_root,
    ) {
    }
}

<?php

namespace App\Data;

use Hash;
use Spatie\LaravelData\Data;

/** @typescript */
class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public bool $is_root,
        public bool $is_supplier,
    ) {
    }

    public static function fromMultiple(
         string $name,
         string $email,
         string $password,
         bool $is_root,
         bool $is_supplier, ): self
    {
        return new self($name, $email, Hash::make($password), $is_root, $is_supplier);
    }
}

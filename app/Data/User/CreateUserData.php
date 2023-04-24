<?php

namespace App\Data\User;

use Hash;
use Spatie\LaravelData\Data;

/** @typescript */
class CreateUserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public bool $is_root,
    ) {
    }

    public static function fromMultiple(
        string $name,
        string $email,
        string $password,
        bool $is_root,
    ): self {
        return new self($name, $email, Hash::make($password), $is_root ?? false);
    }

    public static function fromArray(
        array $data
    ): self {
        return new self($data['name'], $data['email'], Hash::make($data['password']), array_key_exists('is_root', $data) ? $data['is_root'] : false);
    }
}

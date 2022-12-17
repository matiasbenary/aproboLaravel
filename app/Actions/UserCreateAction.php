<?php

namespace App\Actions;

use App\Data\UserData;
use App\Models\User;

class UserCreateAction implements Actions
{
    public function __construct(public UserData $userData)
    {
    }

    public function execute()
    {
        return User::create($this->userData->toArray());
    }
}

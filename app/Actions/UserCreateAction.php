<?php

namespace App\Actions;

use App\Data\EntityData;
use App\Data\UserCreateData;
use App\Data\UserData;
use App\Models\User;

class UserCreateAction implements Actions
{
    public function __construct(public UserCreateData $userData, public EntityData $entityData, public bool $isOwner = false)
    {
    }

    public function execute(): UserData
    {
        $user = User::create($this->userData->toArray());
        $user->entities()->attach($this->entityData->id, ['is_owner' => $this->isOwner]);

        return UserData::from($user);
    }
}

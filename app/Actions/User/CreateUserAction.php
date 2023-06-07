<?php

namespace App\Actions\User;

use App\Data\Entity\EntityData;
use App\Data\User\CreateUserData;
use App\Data\User\UserData;
use App\Models\Role;
use App\Models\User;

class CreateUserAction
{
    public function __construct(public CreateUserData $userData, public EntityData $entityData, public bool $isOwner = false, public string $roleName = 'admin')
    {
    }

    public function execute(): UserData
    {
        $user = User::create($this->userData->toArray());
        $user->entities()->attach($this->entityData->id, ['is_owner' => $this->isOwner]);
        $roles = Role::where('name', $this->roleName)->get();
        $user->roles()->attach($roles, ['entity_id' => $this->entityData->id]);
        // $permissions = Permission::all();

        // foreach ($permissions as $permission) {
        //     $user->permissions()->attach($permission->id, ['entity_id' => $this->entityData->id]);
        // }

        return UserData::from($user);
    }
}

<?php

namespace Tests\Unit\Actions;

use App\Actions\UserCreateAction;
use App\Data\EntityData;
use App\Data\UserCreateData;
use App\Models\Entity;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserActionTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected function getUser(): UserCreateData
    {
        return UserCreateData::from(['name' => 'test', 'email' => 'test@test.com', 'password' => 'qweqwe', 'is_root' => false]);
    }

    public function test_add_new_user()
    {
        $permission = Permission::count();
        $entity = EntityData::from(Entity::factory()->create());

        $userData = $this->getUser();

        $createUser = new UserCreateAction($userData, $entity, false);

        $user = $createUser->execute();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'is_root' => 0,
        ]);

        $this->assertDatabaseHas('entity_user', [
            'user_id' => $user->id,
            'entity_id' => $entity->id,
            'is_owner' => false,
        ]);

        $this->assertDatabaseCount('entity_permission_user', $permission);
    }

    public function test_add_new_user_owner()
    {
        $entity = EntityData::from(Entity::factory()->create());

        $userData = $this->getUser();

        $createUser = new UserCreateAction($userData, $entity, true);

        $user = $createUser->execute();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'is_root' => 0,
        ]);

        $this->assertDatabaseHas('entity_user', [
            'user_id' => $user->id,
            'entity_id' => $entity->id,
            'is_owner' => 1,
        ]);
    }
}

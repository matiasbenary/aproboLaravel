<?php

namespace Tests\Unit\Actions;

use App\Actions\Entity\CreateEntityAction;
use App\Data\Entity\CreateEntityData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateEntityActionTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_entity_complete()
    {
        $entityRequest = CreateEntityData::from(['business_name' => 'test', 'fantasy_name' => 'fantasy', 'cuit' => 123456789, 'cbu' => 9876543211234, 'email' => 'test@test.com']);
        $createEntityAction = new CreateEntityAction($entityRequest);

        $entity = $createEntityAction->execute();

        $this->assertDatabaseHas('entities', [
            'business_name' => 'test',
            'fantasy_name' => 'fantasy',
            'cuit' => 123456789,
            'email' => 'test@test.com',
            'cbu' => 9876543211234,
        ]);
    }

    public function test_create_entity_without_cbu()
    {
        $entityRequest = CreateEntityData::from([
            'business_name' => 'test', 'fantasy_name' => 'fantasy', 'cuit' => 123456789, 'email' => 'test@test.com',
        ]);
        $createEntityAction = new CreateEntityAction($entityRequest);

        $entity = $createEntityAction->execute();

        $this->assertDatabaseHas('entities', [
            'business_name' => 'test',
            'fantasy_name' => 'fantasy',
            'cuit' => 123456789,
            'email' => 'test@test.com',
        ]);
    }
}

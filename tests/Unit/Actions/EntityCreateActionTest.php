<?php

namespace Tests\Unit\Actions;

use App\Actions\EntityCreateAction as ActionsEntityCreateAction;
use App\Data\EntityCreateData;
use Tests\TestCase;

class EntityCreateActionTest extends TestCase
{
    public function test_create_entity_complete()
    {
        // $entityRequest = EntityCreateData::from(['business_name' => 'test', 'fantasy_name' => 'fantasy', 'cuit' => 123456789, 'cbu' => 9876543211234, 'email' => 'test@test.com']);
        // $createEntityAction = new ActionsEntityCreateAction($entityRequest);

        // $entity = $createEntityAction->execute();

        // $this->assertDatabaseHas('entities', [
        //     'business_name' => 'test',
        //     'fantasy_name' => 'fantasy',
        //     'cuit' => 123456789,
        //     'email' => 'test@test.com',
        // ]);
    }

    public function test_create_entity_without_cbu()
    {
        // $entityRequest = EntityCreateData::from([
        //     'business_name' => 'test', 'fantasy_name' => 'fantasy', 'cuit' => 123456789, 'email' => 'test@test.com',
        // ]);
        // $createEntityAction = new ActionsEntityCreateAction($entityRequest);

        // $entity = $createEntityAction->execute();

        // $this->assertDatabaseHas('entities', [
        //     'business_name' => 'test',
        //     'fantasy_name' => 'fantasy',
        //     'cuit' => 123456789,
        //     'email' => 'test@test.com',
        // ]);
    }
}

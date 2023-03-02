<?php

namespace App\Actions;

use App\Data\EntityCreateData;
use App\Data\EntityData;
use App\Models\Entity;

class EntityCreateAction implements Actions
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct(public EntityCreateData $entityData)
    {
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(): EntityData
    {
        $entity = EntityData::from(Entity::firstOrCreate($this->entityData->toArray()));

        return $entity;
    }
}

<?php

namespace App\Actions\Entity;

use App\Data\Entity\CreateEntityData;
use App\Data\Entity\EntityData;
use App\Models\Entity;

class CreateEntityAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct(public CreateEntityData $entityData)
    {
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute()
    {
        return EntityData::from(Entity::firstOrCreate($this->entityData->toArray()));
    }
}

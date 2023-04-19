<?php

use App\Models\Entity;
use Illuminate\Support\Facades\Request;

function getEntityId()
{
    return Request::header('entity-id');
}

function getEntity()
{
    return Entity::find(getEntityId());
}

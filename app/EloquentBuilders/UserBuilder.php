<?php

namespace App\EloquentBuilders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    public function onlySupplier(): self
    {
        return $this->where('is_supplier', true);
    }

    public function findByEmail($email): User|null
    {
        return  $this->whereEmail($email)->first();
    }
}

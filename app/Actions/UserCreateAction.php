<?php

namespace App\Actions;

use App\Data\UserData;
use App\Models\User;

class UserCreateAction implements Actions{
    public function __construct(public UserData $UserData){}

    public function execute()
    {
        info($this->UserData->toArray());
       $user = new User($this->UserData->toArray());
        $user->save();
    }

}

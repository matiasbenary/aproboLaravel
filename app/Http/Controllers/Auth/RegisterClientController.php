<?php

namespace App\Http\Controllers\Auth;

use App\Actions\EntityCreateAction;
use App\Actions\UserCreateAction;
use App\Data\EntityCreateData;
use App\Data\EntityData;
use App\Data\UserCreateData;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterClientController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $entityAction = new EntityCreateAction(EntityCreateData::from($request->all()));
        $entity = EntityData::from($entityAction->execute());
        $userAction = new UserCreateAction(UserCreateData::from($request->all()), $entity, true);
        $userAction->execute();

        return response()->json(['message' => ['Client successfully registered']]);
    }
}

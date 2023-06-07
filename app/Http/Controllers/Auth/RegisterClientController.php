<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Entity\CreateEntityAction;
use App\Actions\Project\CreateProjectAction;
use App\Actions\User\CreateUserAction;
use App\Data\Entity\CreateEntityData;
use App\Data\Project\CreateProjectData;
use App\Data\User\CreateUserData;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterClientController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CreateProjectAction $createProjectAction): JsonResponse
    {
        $entityAction = new CreateEntityAction(CreateEntityData::from($request->all()));
        $entity = $entityAction->execute();
        $userAction = new CreateUserAction(CreateUserData::from($request->all()), $entity, true);
        $userAction->execute();

        if ($request->has('invitation_token') && $client = Entity::where('invitation_token', $request->invitation_token)->first()) {
            Supplier::firstOrCreate(['consumer_id' => $client->id, 'supplier_id' => $entity->id]);
        }

        $projectData = CreateProjectData::from([
            'name' => 'General',
            'entity_id' => $entity->id,
            'payment_order' => 3,
            'execution_process' => 3,
            'purchase_order' => 3,
        ]);
        $createProjectAction->execute($projectData);

        $token = auth()->attempt(['email' => $request->email, 'password' => $request->password]);

        return response()->json([
            'message' => ['Client successfully registered'], 'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'entities' => auth()->user()->entities,
            'user' => auth()->user(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.verify', 'entity.header', 'hasPermission:project']);
    }

    public function index(Request $request)
    {
        $entityId = $request->header('entity-id');
        $project = Project::where('entity_id', $entityId)->get();

        return response()->json(['data' => compact('project')]);
    }

    public function store(StoreProjectRequest $request)
    {
        Project::create(['name' => $request->name, 'entity_id' => $request->header('entity-id'), 'payment_order' => $request->payment_order, 'execution_process' => $request->execution_process, 'purchase_order' => $request->payment_order]);

        return response()->json(['message' => 'Created successfully']);
    }

    public function show(Project $project)
    {
        return response()->json(['data' => compact('project')]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        return response()->json(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}

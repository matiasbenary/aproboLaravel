<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use GuzzleHttp\Handler\Proxy;
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
        $project = Project::select("id", "name")->where("entity_id", $entityId)->get();

        return response()->json(["data" => compact("project")]);
    }

    public function store(StoreProjectRequest $request)
    {

        Project::create(["name" => $request->name, "entity_id" => $request->header("entity-id")]);
        return response()->json(["message" => "Created successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        info($request->toArray());
        info($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}

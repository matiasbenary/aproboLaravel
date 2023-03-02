<?php

namespace Tests\Feature\Http\Controllers\Config;

use App\Models\Entity;
use App\Models\Permission;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\Response;

class ProjectControllerTest extends TestCase
{

    use RefreshDatabase;
    protected function firstStep()
    {

        $this->seed();
        $entity = Entity::factory()->create();


        $userF = User::factory()
            ->hasAttached($entity, [
                'is_owner' => false,
            ])->create([
                'is_root' => false,
            ]);

        $user = User::find($userF->id);
        $token = auth()->login($user);
        $permissionId = Permission::whereName("project")->first()->id;
        \DB::table("entity_permission_user")->insert(["user_id" => $user->id, "entity_id" => $entity->id, "permission_id" => $permissionId]);
        return compact("user", "token", "entity");
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_projects()
    {
        $init = $this->firstStep();
        $entity = $init["entity"];
        $token = $init["token"];

        Project::factory()->for($entity)->create([
            "name" => "Marketing",
            "entity_id" => $entity->id
        ]);

        Project::factory()->for($entity)->create([
            "name" => "It",
            "entity_id" => $entity->id
        ]);

        $this->json('GET', '/api/projects', [], ["Entity-Id" => $entity->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "data" => [
                    "project" => [
                        [
                            'id' => 1,
                            'name'  => "Marketing",
                        ],
                        [
                            'id' => 2,
                            'name'  => "It",
                        ]
                    ]
                ]

            ]);
    }

    public function test_get_project()
    {
        $init = $this->firstStep();
        $entity = $init["entity"];
        $token = $init["token"];

        $project = Project::factory()->for($entity)->create([
            "name" => "Marketing",
            "entity_id" => $entity->id
        ]);

        $this->json('GET', '/api/projects/' . $project->id, [], ["Entity-Id" => $entity->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "data" => [
                    "project" => [
                        'id' => $project->id,
                        'name'  => "Marketing",
                    ]
                ]

            ]);
    }


    public function test_get_all_projects_without_header()
    {
        $init = $this->firstStep();
        $token = $init["token"];

        $this->json('GET', '/api/projects', [], ["Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_get_all_projects_with_error_header()
    {
        $init = $this->firstStep();
        $token = $init["token"];


        $this->json('GET', '/api/projects', [], ["Entity-Id" => 10000, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_create_project()
    {
        $init = $this->firstStep();
        $entity = $init["entity"];
        $user = $init["user"];
        $token = $init["token"];


        $this->json('POST', '/api/projects', ["name" => "test", "payment_order" => 2, "execution_process" => 1, "purchase_order" => 2], ["Entity-Id" => $entity->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);

        $this->assertDatabaseHas('projects', [
            'name' => 'test',
            'entity_id' => $entity->id,
            "payment_order" => 2,
            "execution_process" => 1,
            "purchase_order" => 2
        ]);

        $this->assertDatabaseCount('projects', 1);
    }

    public function test_create_project_without_params()
    {
        $init = $this->firstStep();
        $entity = $init["entity"];
        $token = $init["token"];

        $this->json('POST', '/api/projects', [], ["Entity-Id" => $entity->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['name' => ['The name field is required.']]);
    }

    public function test_edit_project()
    {
        $init = $this->firstStep();
        $entity = $init["entity"];
        $user = $init["user"];
        $token = $init["token"];

        $project = Project::factory()->for($entity)->create([
            "name" => "Marketing",
            "entity_id" => $entity->id,
            "payment_order" => 2,
            "execution_process" => 1,
            "purchase_order" => 2
        ]);


        $this->json('PUT', '/api/projects/' . (string)$project->id, [
            "name" => "Comunicaciones",
            "payment_order" => 12,
            "execution_process" => 10,
            "purchase_order" => 12
        ], ["Entity-Id" => $entity->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Updated successfully']);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Comunicaciones',
            'entity_id' => $entity->id,
            "payment_order" => 12,
            "execution_process" => 10,
            "purchase_order" => 12
        ]);

        // $this->assertDatabaseCount('projects', 1);
    }
}

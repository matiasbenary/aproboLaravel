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

    protected $entity;
    protected $token;
    //add variables here
    protected $user;


    protected function setUp(): void
    {
        parent::setUp();
        // $this->artisan('migrate:fresh');

        $this->seed();
        $this->entity = Entity::factory()->create();


        $userF = User::factory()
            ->hasAttached($this->entity, [
                'is_owner' => false,
            ])->create([
                'is_root' => false,
            ]);

        $this->user = User::find($userF->id);
        $this->token = auth()->login($this->user);

        $permissionId = Permission::whereName("project")->first()->id;
        \DB::table("entity_permission_user")->insert(["user_id" => $this->user->id, "entity_id" => $this->entity->id, "permission_id" => $permissionId]);

        Project::factory()->for($this->entity)->create([
            "name" => "Marketing",
            "entity_id" => $this->entity->id
        ]);

        Project::factory()->for($this->entity)->create([
            "name" => "It",
            "entity_id" => $this->entity->id
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_projects()
    {
        $this->json('GET', '/api/projects', [], ["Entity-Id" => $this->entity->id, "Authorization" => "Bearer " . $this->token])
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
        $project = Project::factory()->for($this->entity)->create([
            "name" => "Marketing",
            "entity_id" => $this->entity->id
        ]);

        $this->json('GET', '/api/projects/' . $project->id, [], ["Entity-Id" => $this->entity->id, "Authorization" => "Bearer " . $this->token])
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
        $this->json('GET', '/api/projects', [], ["Authorization" => "Bearer " . $this->token])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_get_all_projects_with_error_header()
    {
        $this->json('GET', '/api/projects', [], ["Entity-Id" => 10000, "Authorization" => "Bearer " . $this->token])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_create_project()
    {
        $this->json('POST', '/api/projects', ["name" => "test", "payment_order" => 2, "execution_process" => 1, "purchase_order" => 2], ["Entity-Id" => $this->entity->id, "Authorization" => "Bearer " . $this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);

        $this->assertDatabaseHas('projects', [
            'name' => 'test',
            'entity_id' => $this->entity->id,
            "payment_order" => 2,
            "execution_process" => 1,
            "purchase_order" => 2
        ]);

        $this->assertDatabaseCount('projects', 3);
    }

    public function test_create_project_without_params()
    {
        $this->json('POST', '/api/projects', [], ["Entity-Id" => $this->entity->id, "Authorization" => "Bearer " . $this->token])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['name' => ['The name field is required.']]);
    }

    public function test_edit_project()
    {
        $project = Project::factory()->for($this->entity)->create([
            "name" => "Marketing",
            "entity_id" => $this->entity->id,
            "payment_order" => 2,
            "execution_process" => 1,
            "purchase_order" => 2
        ]);


        $this->json('PUT', '/api/projects/' . (string)$project->id, [
            "name" => "Comunicaciones",
            "payment_order" => 12,
            "execution_process" => 10,
            "purchase_order" => 12
        ], ["Entity-Id" => $this->entity->id, "Authorization" => "Bearer " . $this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Updated successfully']);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Comunicaciones',
            'entity_id' => $this->entity->id,
            "payment_order" => 12,
            "execution_process" => 10,
            "purchase_order" => 12
        ]);

        $this->assertDatabaseCount('projects', 3);
    }
}

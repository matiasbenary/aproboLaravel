<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Entity;
use App\Models\Permission;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function firstStep()
    {
        $this->seed();
        $entity = Entity::factory()->create();

        /** @var \App\Models\User $userF **/
        $userF = User::factory()
            ->hasAttached($entity, [
                'is_owner' => false,
            ])->create([
                'is_root' => false,
            ]);
        /** @var \App\Models\User $user **/
        $user = User::find($userF->id);
        $token = auth()->login($user);
        $permissionId = Permission::whereName("invoice")->first()->id;
        \DB::table("entity_permission_user")->insert(["user_id" => $user->id, "entity_id" => $entity->id, "permission_id" => $permissionId]);
        return compact("user", "token", "entity");
    }

    public function test_get_all_invoices_without_header()
    {
        $init = $this->firstStep();
        $token = $init["token"];

        $this->json('GET', '/api/invoices', [], ["Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_get_all_invoices_with_error_header()
    {
        $init = $this->firstStep();
        $token = $init["token"];


        $this->json('GET', '/api/invoices', [], ["Entity-Id" => 10000, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * TODO:
     * send email notification
     * validate invoices
     */
    public function test_create_invoices_simple()
    {
        $init = $this->firstStep();
        $entity = $init["entity"];
        $user = $init["user"];
        $token = $init["token"];

        /** @var \App\Models\Entity $entity1 **/
        $entity1 = Entity::factory()->create();

        /** @var \App\Models\Project $project **/
        $project = Project::factory()->for($entity)->create([
            "name" => "Marketing",
            "entity_id" => $entity->id
        ]);

        $this->json('POST', '/api/invoices', [
            "consumer_id" => $entity1->id,
            "supplier_id" => $entity->id,
            "user_id" => $user->id,
            "project_id" => $project->id,
            "type" => "C",
            "amount" => 12345678,
            "currency" => "ARS",
            "responsible_email" => "test@test.com",
            "message" => "hola, soy un texto de ejemplo"
        ], ["Entity-Id" => $entity->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);

        $this->assertDatabaseHas('invoices', [
            "consumer_id" => $entity1->id,
            "supplier_id" => $entity->id,
            "user_id" => $user->id,
            "project_id" => $project->id,
            "type" => "C",
            "amount" => 12345678,
            "currency" => "ARS",
            "responsible_email" => "test@test.com",
            "message" => "hola, soy un texto de ejemplo"
        ]);

        $this->assertDatabaseCount('invoices', 1);
    }

    public function test_create_invoices_with_file()
    {
        $init = $this->firstStep();
        $entity = $init["entity"];
        $user = $init["user"];
        $token = $init["token"];

        $file = UploadedFile::fake()->image('factura.pdf');

        /** @var \App\Models\Entity $entity1 **/
        $entity1 = Entity::factory()->create();

        /** @var \App\Models\Project $project **/
        $project = Project::factory()->for($entity)->create([
            "name" => "Marketing",
            "entity_id" => $entity->id
        ]);

        $this->json('POST', '/api/invoices', [
            "consumer_id" => $entity1->id,
            "supplier_id" => $entity->id,
            "user_id" => $user->id,
            "project_id" => $project->id,
            "type" => "C",
            "amount" => 12345678,
            "currency" => "ARS",
            "responsible_email" => "test@test.com",
            "message" => "hola, soy un texto de ejemplo",
            "file" => $file
        ], ["Entity-Id" => $entity->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);

        $this->assertDatabaseHas('invoices', [
            "consumer_id" => $entity1->id,
            "supplier_id" => $entity->id,
            "user_id" => $user->id,
            "project_id" => $project->id,
            "type" => "C",
            "amount" => 12345678,
            "currency" => "ARS",
            "responsible_email" => "test@test.com",
            "message" => "hola, soy un texto de ejemplo",
            "media_id" => 1
        ]);

        Storage::disk()->assertExists('invoices/' . $file->hashName());

        $this->assertDatabaseCount('media', 1);

        $this->assertDatabaseCount('invoices', 1);
    }
}

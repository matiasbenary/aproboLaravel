<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Entity;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected $user;

    protected $consumer;

    protected $project;

    protected $supplier;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');

        $this->seed();

        /** @var \App\Models\Entity $this->consumer * */
        $this->consumer = Entity::factory()->create();

        $userF = User::factory()
            ->hasAttached($this->consumer, [
                'is_owner' => false,
            ])->create([
                'is_root' => false,
            ]);

        $this->user = User::find($userF->id);
        $this->token = auth()->login($this->user);

        $role = Role::whereName('admin')->first();
        $userF->roles()->attach($role, ['entity_id' => $this->consumer->id]);

        /** @var \App\Models\Project $this->project * */
        $this->project = Project::factory()->for($this->consumer)->create([
            'name' => 'Marketing',
            'entity_id' => $this->consumer->id,
        ]);

        /** @var \App\Models\Entity $this->supplier * */
        $this->supplier = Entity::factory()->create();
    }

    public function test_get_all_invoices_without_header()
    {
        $this->json('GET', '/api/invoices/consumer', [], ['Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_get_all_invoices_with_error_header()
    {
        $this->json('GET', '/api/invoices/consumer', [], ['Entity-Id' => 10000, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * TODO:
     * send email notification
     * validate invoices
     */
    public function test_create_invoices_simple()
    {
        $this->json('POST', '/api/invoices', [
            'consumer_id' => $this->consumer->id,
            'supplier_id' => $this->supplier->id,
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'type' => 'C',
            'amount' => 12345678,
            'currency' => 'ARS',
            'responsible_email' => 'test@test.com',
            'message' => 'hola, soy un texto de ejemplo',
        ], ['Entity-Id' => $this->consumer->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);

        $this->assertDatabaseHas('invoices', [
            'consumer_id' => $this->consumer->id,
            'supplier_id' => $this->supplier->id,
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'type' => 'C',
            'amount' => 12345678,
            'currency' => 'ARS',
            'responsible_email' => 'test@test.com',
            'message' => 'hola, soy un texto de ejemplo',
        ]);

        $this->assertDatabaseCount('invoices', 1);
    }

    public function test_create_invoices_with_file()
    {
        $file = UploadedFile::fake()->image('factura.pdf');

        $this->json('POST', '/api/invoices', [
            'consumer_id' => $this->supplier->id,
            'supplier_id' => $this->consumer->id,
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'type' => 'C',
            'amount' => 12345678,
            'currency' => 'ARS',
            'responsible_email' => 'test@test.com',
            'message' => 'hola, soy un texto de ejemplo',
            'file' => $file,
        ], ['Entity-Id' => $this->consumer->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);

        $this->assertDatabaseHas('invoices', [
            'consumer_id' => $this->supplier->id,
            'supplier_id' => $this->consumer->id,
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'type' => 'C',
            'amount' => 12345678,
            'currency' => 'ARS',
            'responsible_email' => 'test@test.com',
            'message' => 'hola, soy un texto de ejemplo',
        ]);

        Storage::disk()->assertExists('invoices/'.$file->hashName());

        $this->assertDatabaseCount('media', 1);

        $this->assertDatabaseCount('invoices', 1);
    }

    //    create test show invoices
    public function test_show_invoices_for_consumer()
    {
        $invoice = Invoice::factory()->create([
            'consumer_id' => $this->consumer->id,
            'supplier_id' => $this->supplier->id,
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'type' => 'C',
            'amount' => 12345678,
            'currency' => 'ARS',
            'responsible_email' => 'test@test.com',
            'message' => 'hola, soy un texto de ejemplo',
        ]);

        $invoice2 = Invoice::factory()->create([
            'consumer_id' => $this->supplier->id,
            'supplier_id' => $this->consumer->id,
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'type' => 'C',
            'amount' => 12345678,
            'currency' => 'ARS',
            'responsible_email' => 'test@test.com',
            'message' => 'hola, soy un texto de ejemplo',
        ]);

        $this->json('GET', '/api/invoices/consumer', ['Entity-Id' => $this->consumer->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_OK);
        // ->assertJson();
    }
}

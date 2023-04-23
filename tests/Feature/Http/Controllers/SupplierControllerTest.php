<?php

namespace Tests\Feature\Http\Controllers;

use App\Mail\SendInvitationSupplier;
use App\Models\Entity;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Mail;
use Tests\TestCase;

class SupplierControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected $user;

    protected $consumer;

    protected $supplier1;

    protected $supplier2;

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

        $permissionId = Permission::whereName('supplier')->first()->id;
        \DB::table('entity_permission_user')->insert(['user_id' => $this->user->id, 'entity_id' => $this->consumer->id, 'permission_id' => $permissionId]);

        /** @var \App\Models\Entity $this->supplier1 * */
        $this->supplier1 = Entity::factory()->create();

        /** @var \App\Models\Entity $this->supplier2 * */
        $this->supplier2 = Entity::factory()->create();

        \DB::table('suppliers')->insert(['consumer_id' => $this->consumer->id, 'supplier_id' => $this->supplier1->id]);
        \DB::table('suppliers')->insert(['consumer_id' => $this->consumer->id, 'supplier_id' => $this->supplier2->id]);
    }

    public function test_get_all_suppliers_without_header()
    {
        $this->json('GET', '/api/suppliers', [], ['Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_get_all_suppliers_with_error_header()
    {
        $this->json('GET', '/api/suppliers', [], ['Entity-Id' => 10000, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_get_all_suppliers()
    {
        $this->json('GET', '/api/suppliers', [], ['Entity-Id' => $this->consumer->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'supplier' => [
                        [
                            'id' => $this->supplier1->id,
                            'business_name' => $this->supplier1->business_name,
                            'fantasy_name' => $this->supplier1->fantasy_name,
                            'email' => $this->supplier1->email,
                            'cuit' => $this->supplier1->cuit,
                            'cbu' => $this->supplier1->cbu,
                        ],
                        [
                            'id' => $this->supplier2->id,
                            'business_name' => $this->supplier2->business_name,
                            'fantasy_name' => $this->supplier2->fantasy_name,
                            'email' => $this->supplier2->email,
                            'cuit' => $this->supplier2->cuit,
                            'cbu' => $this->supplier2->cbu,
                        ],
                    ],
                ],

            ]);
    }

    public function test_create_supplier()
    {
        $this->json('POST', '/api/suppliers', ['business_name' => 'test', 'fantasy_name' => 'test', 'email' => 'supplier@test.com', 'cuit' => 12345678, 'cbu' => 12345678], ['Entity-Id' => $this->consumer->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);

        $this->assertDatabaseHas('entities', [
            'business_name' => 'test',
            'fantasy_name' => 'test',
            'email' => 'supplier@test.com',
            'cuit' => 12345678,
            'cbu' => 12345678,
        ]);

        $this->assertDatabaseHas('suppliers', [
            'consumer_id' => $this->consumer->id,
        ]);

        $this->assertDatabaseCount('entities', 4);
    }

    public function test_create_existing_supplier()
    {
        $this->json('POST', '/api/suppliers', [
            'business_name' => $this->supplier1->business_name,
            'fantasy_name' => $this->supplier1->fantasy_name,
            'email' => $this->supplier1->email,
            'cuit' => $this->supplier1->cuit,
            'cbu' => $this->supplier1->cbu,
        ], ['Entity-Id' => $this->consumer->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);

        $this->assertDatabaseHas('suppliers', [
            'consumer_id' => $this->consumer->id,
            'supplier_id' => $this->supplier1->id,
        ]);

        $this->assertDatabaseCount('suppliers', 3);
    }

    public function test_create_existing_relationship_supplier()
    {
        \DB::table('suppliers')->insert(['consumer_id' => $this->consumer->id, 'supplier_id' => $this->supplier1->id]);

        $this->json('POST', '/api/suppliers', [
            'business_name' => $this->supplier1->business_name,
            'fantasy_name' => $this->supplier1->fantasy_name,
            'email' => $this->supplier1->email,
            'cuit' => $this->supplier1->cuit,
            'cbu' => $this->supplier1->cbu,
        ], ['Entity-Id' => $this->consumer->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);

        $this->assertDatabaseHas('suppliers', [
            'consumer_id' => $this->consumer->id,
            'supplier_id' => $this->supplier1->id,
        ]);

        $this->assertDatabaseCount('suppliers', 4);
    }

    public function test_send_invite_email_incorrect()
    {
        $this->json('POST', '/api/suppliers/sendInvitation', ['email' => 'pepe'], ['Entity-Id' => $this->consumer->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_send_invite_email()
    {
        Mail::fake();

        $this->json('POST', '/api/suppliers/sendInvitation', ['email' => 'pepe@test.com'], ['Entity-Id' => $this->consumer->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Invitation sent successfully']);

        Mail::assertSent(SendInvitationSupplier::class, function ($mail) {
            return $mail->hasTo('pepe@test.com');
        });
    }
}

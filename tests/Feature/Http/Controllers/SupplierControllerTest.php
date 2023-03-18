<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Entity;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SupplierControllerTest extends TestCase
{
    //TODO:
    //Send email to new supplier
    //Validate Create

    use  DatabaseTransactions;
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
        $permissionId = Permission::whereName("supplier")->first()->id;
        \DB::table("entity_permission_user")->insert(["user_id" => $user->id, "entity_id" => $entity->id, "permission_id" => $permissionId]);
        return compact("user", "token", "entity");
    }

    public function test_get_all_suppliers_without_header()
    {
        $init = $this->firstStep();
        $token = $init["token"];

        $this->json('GET', '/api/suppliers', [], ["Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_get_all_suppliers_with_error_header()
    {
        $init = $this->firstStep();
        $token = $init["token"];


        $this->json('GET', '/api/suppliers', [], ["Entity-Id" => 10000, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }


    public function test_get_all_suppliers()
    {
        $init = $this->firstStep();
        $entity = $init["entity"];
        $token = $init["token"];
        /** @var \App\Models\Entity $entity1 **/
        $entity1 = Entity::factory()->create();
        /** @var \App\Models\Entity $entity2 **/
        $entity2 = Entity::factory()->create();

        \DB::table("suppliers")->insert(["consumer_id" => $entity->id, "supplier_id" => $entity1->id]);
        \DB::table("suppliers")->insert(["consumer_id" => $entity->id, "supplier_id" => $entity2->id]);
        $this->json('GET', '/api/suppliers', [], ["Entity-Id" => $entity->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                "data" => [
                    "supplier" => [
                        [
                            'id' => $entity1->id,
                            'business_name'  => $entity1->business_name,
                            'fantasy_name' => $entity1->fantasy_name,
                            'email' => $entity1->email,
                            'cuit' => $entity1->cuit,
                            'cbu' => $entity1->cbu,
                        ],
                        [
                            'id' => $entity2->id,
                            'business_name'  => $entity2->business_name,
                            'fantasy_name' => $entity2->fantasy_name,
                            'email' => $entity2->email,
                            'cuit' => $entity2->cuit,
                            'cbu' => $entity2->cbu,
                        ]
                    ]
                ]

            ]);
    }

    public function test_create_supplier()
    {
        // $init = $this->firstStep();
        // $entity = $init["entity"];
        // $user = $init["user"];
        // $token = $init["token"];

        // $this->json('POST', '/api/suppliers', ["business_name" => "test", "fantasy_name" => "test", "email" => "supplier@test.com", "cuit" => 12345678, "cbu" => 12345678], ["Entity-Id" => $entity->id, "Authorization" => "Bearer $token"])
        //     ->assertStatus(Response::HTTP_OK)
        //     ->assertJson(['message' => 'Created successfully']);

        // $this->assertDatabaseHas('entities', [
        //     'business_name' => 'test',
        //     'fantasy_name' => 'test',
        //     'email' => 'supplier@test.com',
        //     'cuit' => 12345678,
        //     'cbu' => 12345678
        // ]);

        // $this->assertDatabaseHas('suppliers', [
        //     'consumer_id' => $entity->id,
        // ]);


        // $this->assertDatabaseCount('entities', 4);
    }

    public function test_create_existing_supplier()
    {
        $init = $this->firstStep();
        $consumer = $init["entity"];
        $user = $init["user"];
        $token = $init["token"];

        /** @var \App\Models\Entity $supplier **/
        $supplier = Entity::factory()->create();

        $this->json('POST', '/api/suppliers', [
            "business_name" => $supplier->business_name,
            "fantasy_name" => $supplier->fantasy_name,
            "email" => $supplier->email,
            "cuit" => $supplier->cuit,
            "cbu" => $supplier->cbu
        ], ["Entity-Id" => $consumer->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);


        $this->assertDatabaseHas('suppliers', [
            'consumer_id' => $consumer->id,
            'supplier_id' => $supplier->id
        ]);


        $this->assertDatabaseCount('suppliers', 1);
    }

    public function test_create_existing_relationship_supplier()
    {
        $init = $this->firstStep();
        $consumer = $init["entity"];
        $user = $init["user"];
        $token = $init["token"];

        /** @var \App\Models\Entity $supplier **/
        $supplier = Entity::factory()->create();

        \DB::table("suppliers")->insert(["consumer_id" => $consumer->id, "supplier_id" => $supplier->id]);

        $this->json('POST', '/api/suppliers', [
            "business_name" => $supplier->business_name,
            "fantasy_name" => $supplier->fantasy_name,
            "email" => $supplier->email,
            "cuit" => $supplier->cuit,
            "cbu" => $supplier->cbu
        ], ["Entity-Id" => $consumer->id, "Authorization" => "Bearer $token"])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Created successfully']);


        $this->assertDatabaseHas('suppliers', [
            'consumer_id' => $consumer->id,
            'supplier_id' => $supplier->id
        ]);


        $this->assertDatabaseCount('suppliers', 1);
    }
}

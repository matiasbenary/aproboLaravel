<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Entity;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ConsumerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected $user;

    protected $supplier;

    protected $consumer1;

    protected $consumer2;

    protected $project1;

    protected $project2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed();

        /** @var \App\Models\Entity $this->supplier * */
        $this->supplier = Entity::factory()->create();

        $userF = User::factory()
            ->hasAttached($this->supplier, [
                'is_owner' => false,
            ])->create([
                'is_root' => false,
            ]);

        $this->user = User::find($userF->id);
        $this->token = auth()->login($this->user);

        $role = Role::whereName('admin')->first();
        $userF->roles()->attach($role, ['entity_id' => $this->supplier->id]);

        /** @var \App\Models\Entity $this->consumer1 * */
        $this->consumer1 = Entity::factory()->create();

        $this->project1 = Project::factory()->for($this->consumer1)->create([
            'name' => 'Marketing',
            'entity_id' => $this->consumer1->id,
        ]);

        $this->project2 = Project::factory()->for($this->consumer1)->create([
            'name' => 'It',
            'entity_id' => $this->consumer1->id,
        ]);

        /** @var \App\Models\Entity $this->consumer2 * */
        $this->consumer2 = Entity::factory()->create();

        Project::factory()->for($this->consumer2)->create([
            'name' => 'General',
            'entity_id' => $this->consumer2->id,
        ]);

        Project::factory()->for($this->consumer2)->create([
            'name' => 'RRHH',
            'entity_id' => $this->consumer2->id,
        ]);

        \DB::table('suppliers')->insert(['supplier_id' => $this->supplier->id, 'consumer_id' => $this->consumer1->id]);
        \DB::table('suppliers')->insert(['supplier_id' => $this->supplier->id, 'consumer_id' => $this->consumer2->id]);
    }

    public function test_get_all_consumer_without_header()
    {
        $this->json('GET', '/api/consumers', [], ['Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_get_all_consumer_with_error_header()
    {
        $this->json('GET', '/api/consumers', [], ['Entity-Id' => 10000, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_consumers()
    {
        $this->json('GET', '/api/consumers', [], ['Entity-Id' => $this->supplier->id, 'Authorization' => 'Bearer '.$this->token])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'consumer' => [
                        [
                            'id' => (int) $this->consumer1->id,
                            'business_name' => $this->consumer1->business_name,
                            'fantasy_name' => $this->consumer1->fantasy_name,
                            'email' => $this->consumer1->email,
                            'cuit' => (int) $this->consumer1->cuit,
                            'cbu' => (int) $this->consumer1->cbu,
                            'invitation_token' => $this->consumer1->invitation_token,
                            'projects' => [
                                [
                                    'id' => 1,
                                    'name' => 'Marketing',
                                ],
                                [
                                    'id' => 2,
                                    'name' => 'It',
                                ],
                            ],

                        ],
                        [
                            'id' => (int) $this->consumer2->id,
                            'business_name' => $this->consumer2->business_name,
                            'fantasy_name' => $this->consumer2->fantasy_name,
                            'email' => $this->consumer2->email,
                            'cuit' => (int) $this->consumer2->cuit,
                            'cbu' => (int) $this->consumer2->cbu,
                            'invitation_token' => $this->consumer2->invitation_token,
                            'projects' => [
                                [
                                    'id' => 3,
                                    'name' => 'General',
                                ],
                                [
                                    'id' => 4,
                                    'name' => 'RRHH',
                                ],
                            ],

                        ],
                    ],
                ],
            ]);
    }
}

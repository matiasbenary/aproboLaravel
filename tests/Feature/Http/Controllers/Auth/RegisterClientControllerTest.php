<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterClientControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_successfully_register_the_client()
    {
        $response = $this->postJson('api/registerClient', ['name' => 'test testing', 'business_name' => 'empresa de test', 'email' => 'creacionUser@test.com', 'cuit' => 123456789, 'password' => 'password']); // ['name' => 'test testing', 'business_name' => 'empresa de test', 'email' => 'test@test.com', 'cuit' => 123456789, 'password' => "password"]);

        $response->assertStatus(200)
            ->assertJson(['message' => ['Client successfully registered']])
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'entities'
            ]);
        $this->assertDatabaseHas('users', [
            'name' => 'test testing',
            'email' => 'creacionUser@test.com',
            'is_root' => 0,
        ]);

        $this->assertDatabaseHas('entities', [
            'business_name' => 'empresa de test',
            'cuit' => 123456789,
        ]);
    }

    public function test_successfully_register_the_supplier()
    {
        $entity = Entity::factory()->create();
        $response = $this->postJson('api/registerClient', ['name' => 'test testing', 'business_name' => 'empresa de test', 'email' => 'creacionUser@test.com', 'cuit' => 123456789, 'password' => 'password', 'invitation_token' => $entity->invitation_token]); // ['name' => 'test testing', 'business_name' => 'empresa de test', 'email' => 'test@test.com', 'cuit' => 123456789, 'password' => "password"]);

        $response->assertStatus(200)
            ->assertJson(['message' => ['Client successfully registered']])
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'entities'
            ]);
        $this->assertDatabaseHas('users', [
            'name' => 'test testing',
            'email' => 'creacionUser@test.com',
            'is_root' => 0,
        ]);

        $this->assertDatabaseHas('entities', [
            'business_name' => 'empresa de test',
            'cuit' => 123456789,
        ]);

        $this->assertDatabaseHas('suppliers', [
            'consumer_id' => $entity->id,
        ]);
    }
}

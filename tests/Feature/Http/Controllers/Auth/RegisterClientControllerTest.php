<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterEntityControllerTest extends TestCase
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

        $response->assertStatus(200)->assertJson(['message' => ['Client successfully registered']]);
        $this->assertDatabaseHas('users', [
            'name' => 'test testing',
            'email' => 'creacionUser@test.com',
            'is_root' => 0,
        ]);
    }
}

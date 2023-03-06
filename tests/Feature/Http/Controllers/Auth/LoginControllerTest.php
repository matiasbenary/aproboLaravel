<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function test_it_return_true_if_user_exits_in_check_email()
    {
        $user = User::factory()->create();
        $response = $this->postJson('api/checkEmail', ['email' => $user->email]);

        $response->assertStatus(200)
            ->assertJson(['user' => ['The user exists']]);
    }

    public function test_it_return_false_if_email_is_not_send_in_check_email()
    {
        $response = $this->postJson('api/checkEmail');

        $response->assertStatus(422)
            ->assertJson(['email' => ['The email field is required.']]);
    }

    public function test_it_return_false_if_user_not_exits_in_check_email()
    {
        $response = $this->postJson('api/checkEmail', ['email' => 'test@test.com']);
        $response->assertStatus(422)
            ->assertJson(['user' => ['The user does not exist']]);
    }

    public function test_it_return_token_if_login_is_successful_in_login()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => Hash::make($password)]);

        $response = $this->postJson('api/login', ['email' => $user->email, 'password' => $password]);

        $response->assertStatus(200);
    }

    public function test_it_return_fail_login()
    {
        $response = $this->postJson('api/login', ['email' => 'random@123.com', 'password' => 'password123']);

        $response->assertStatus(401);
    }

    public function test_it_return_token_if_login_is_successful_in_login_with_correct_email_and_password()
    {
        $password = 'password';
        $user = User::factory()->create(['password' => Hash::make($password)]);

        $response = $this->postJson('api/login', ['email' => $user->email, 'password' => $password]);
        // assert that the response status is 200 OK and token is not null
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'entities'
        ]);
    }
}

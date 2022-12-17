<?php

namespace Tests\Unit\Actions;

use App\Actions\UserCreateAction;
use App\Data\UserData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mail;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    protected function getUser(): UserData
    {
        return UserData::from(name: 'test', email: 'test@test.com', password: 'qweqwe', is_root: false, is_supplier: true);
    }

    public function test_add_new_user()
    {
        $userData = $this->getUser();

        $createUser = new UserCreateAction($userData);
        $createUser->execute();

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
            'is_root' => 0,
            'is_supplier' => 1,
        ]);
    }

    // public function test_send_email_new_user()
    // {
    //     $userData = $this->getUser();
    //     Mail::fake();

    //     $createUser = new UserCreateAction($userData);
    //     $createUser->execute();

    //     Mail::assertSent(OrderShipped::class);();
    // }
}

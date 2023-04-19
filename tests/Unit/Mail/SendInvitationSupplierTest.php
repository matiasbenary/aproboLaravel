<?php

namespace Tests\Unit\Mail;

use App\Mail\SendInvitationSupplier;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendInvitationSupplierTest extends TestCase
{
    use RefreshDatabase;

    public function test_mailable_content()
    {
        $user = User::factory()->create();
        $entity = Entity::factory()->create();

        $mailable = new SendInvitationSupplier($entity);
        $mailable->assertSeeInHtml("{$entity->business_name}");
        $mailable->assertSeeInHtml("register?code={$entity->invitation_token}");
    }
}

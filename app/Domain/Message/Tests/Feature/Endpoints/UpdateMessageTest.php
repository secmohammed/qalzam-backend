<?php

namespace App\Domain\Message\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Message\Entities\Message;

class UpdateMessageTest extends TestCase
{
    /** @test */
    public function it_should_let_user_update_message()
    {
        $message = $this->messageFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs($user, 'PUT',
            route('api.messages.update', $message->id), [
                'body' => 'HELLO',
                'title' => 'hello',
                'type' => 'push_notification',
            ]
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'type',
                'body',
                'title',
                'created_at_human',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_update_message_if_doesnt_exist()
    {
        $this->put(
            route('api.messages.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_message_if_doesnt_have_permission()
    {
        $message = $this->messageFactory->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.messages.update', $message->id), $message->toArray()
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_message_if_unauthenticated()
    {
        $message = $this->messageFactory->create();
        $this->put(
            route('api.messages.update', $message->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->messageFactory = Message::factory();
    }
}

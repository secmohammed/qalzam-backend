<?php

namespace App\Domain\Message\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Message\Entities\Message;

class DestroyMessageTest extends TestCase
{
    /** @test */
    public function it_should_delete_message_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $message = $this->messageFactory->count(2)->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $message->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.messages.destroy', $ids)
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_destroy_message_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.messages.destroy', 1)
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_destroy_message_if_message_is_delayed_and_in_past()
    {
        $user = $this->userFactory->create();
        $messages = $this->messageFactory->count(2)->create([
            'delay' => now()->subMonth(1),
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $messages->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.messages.destroy', $ids)
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_destroy_message_if_not_having_permission_of_deleting_message()
    {
        $message = $this->messageFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.messages.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_message_if_unauthenticated()
    {
        $this->delete(
            route('api.messages.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->messageFactory = Message::factory();
    }
}

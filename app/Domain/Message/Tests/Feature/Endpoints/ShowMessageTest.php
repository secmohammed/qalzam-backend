<?php

namespace App\Domain\Message\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Message\Entities\Message;

class ShowMessageTest extends TestCase
{
    /** @test */
    public function it_should_fetch_message_by_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $message = $this->messageFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.messages.show', $message->id)
        )->assertJsonStructure([
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
    public function it_shouldnt_fetch_message_by_id_if_not_found()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs(
            $user,
            'GET',
            route('api.messages.show', 100)
        )->assertStatus(404);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->messageFactory = Message::factory();
    }
}

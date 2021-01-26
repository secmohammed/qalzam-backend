<?php

namespace App\Domain\Message\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Message\Entities\Message;

class IndexMessagesTest extends TestCase
{
    /** @test */
    public function it_should_fetch_messages()
    {
        $messages = $this->messageFactory->count(3)->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'GET', route('api.messages.index'));
        $this->assertCount(3, $response->getData(true)['data']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->messageFactory = Message::factory();
    }
}

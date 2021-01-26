<?php

namespace App\Domain\Message\Tests\Feature\Endpoints;

use Queue;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Message\Entities\Message;
use App\Domain\Message\Jobs\BroadcastMessageToUsers;

class StoreMessageTest extends TestCase
{
    /** @test */
    public function it_should_store_message()
    {
        Queue::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $message = $this->messageFactory->make()->toArray();
        $response = $this->jsonAs($user, 'POST',
            route('api.messages.store'), $message
        )->assertStatus(201)->assertJsonStructure([
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
    public function it_should_store_message_and_assert_job_pushed_with_payload_of_message_in_particular()
    {
        Queue::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $message = $this->messageFactory->make()->toArray();
        $response = $this->jsonAs($user, 'POST',
            route('api.messages.store'), $message
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'type',
                'body',
                'title',
                'created_at_human',

            ],
        ]);
        Queue::assertPushed(BroadcastMessageToUsers::class, function ($job) use ($response) {
            return $job->message->id === $response->getData(true)['data']['id'];
        });
    }

    /** @test */
    public function it_should_store_message_and_push_on_messages_queue()
    {
        Queue::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $message = $this->messageFactory->make()->toArray();
        $response = $this->jsonAs($user, 'POST',
            route('api.messages.store'), $message
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'type',
                'body',
                'title',
                'created_at_human',

            ],
        ]);
        Queue::assertPushedOn('messages', BroadcastMessageToUsers::class);

    }

    /** @test */
    public function it_should_store_message_with_delay()
    {
        Queue::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $message = $this->messageFactory->make([
            'delay' => now()->addDays(3),
        ])->toArray();
        $response = $this->jsonAs($user, 'POST',
            route('api.messages.store'), $message
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'type',
                'body',
                'title',
                'created_at_human',

            ],
        ]);
        Queue::assertPushed(BroadcastMessageToUsers::class, function ($job) use ($response) {
            return $job->delay->toDateTimeString() === $response->getData(true)['data']['delayed_until'];
        });
    }

    /** @test */
    public function it_should_store_message_without_delay_and_assert_job_is_dipsatched_instantly()
    {
        Queue::fake();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $message = $this->messageFactory->make([
        ])->toArray();
        $response = $this->jsonAs($user, 'POST',
            route('api.messages.store'), $message
        )->assertStatus(201)->assertJsonStructure([
            'data' => [
                'id',
                'type',
                'body',
                'title',
                'created_at_human',

            ],
        ]);
        Queue::assertPushed(BroadcastMessageToUsers::class, function ($job) use ($response) {
            return $job->delay === 0;
        });
    }

    /** @test */
    public function it_shouldnt_let_user_create_message_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.messages.store'), [
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_store_message_if_unauthenticated()
    {
        $this->post(
            route('api.messages.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->messageFactory = Message::factory();
    }
}

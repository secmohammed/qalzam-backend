<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Notification;

use Tests\TestCase;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Notifications\DatabaseNotification;

class IndexUserNotificationsTest extends TestCase
{
    /** @test */
    public function it_indexes_user_notifications()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->create();
        $comment = $feed->comment([
            'body' => 'hello there',
            'user_id' => $user->id,
            'commentable_id' => $feed->id,
        ]);

        $notification = DatabaseNotification::create([
            'id' => "ed55739d-c51b-4ee3-976f-6bfd0e8c1a8e",
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'type' => 'database',
            'data' => [
                'id' => $feed->id,
                'link' => route('feeds.show', $feed->id),
                'message' => sprintf('%s commented on your feed', $comment->user->name),
            ],
        ]);
        $response = $this->jsonAs($user, 'GET', '/api/notifications');
        $this->assertEquals($notification->id, json_decode($response->getContent(), true)['data'][0]['id']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->feedFactory = Feed::factory();
    }
}

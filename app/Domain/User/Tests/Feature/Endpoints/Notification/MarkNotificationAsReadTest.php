<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Notification;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Notifications\DatabaseNotification;

class MarkNotificationAsReadTest extends TestCase
{
    /** @test */
    public function it_should_mark_all_notifications_as_read_if_there_is_no_notification_passed()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create();
        $comment = $feed->comment([
            'body' => 'hello there',
            'user_id' => $user->id,
            'commentable_id' => $feed->id,
        ]);
        $notification = DatabaseNotification::create([
            'id' => Str::uuid(),
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'type' => 'database',
            'data' => [
                'id' => $feed->id,
                'link' => route('feeds.show', $feed->id),
                'message' => sprintf('%s commented on your feed', $comment->user->name),
            ],
        ]);
        $anotherNotification = DatabaseNotification::create([
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

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT', '/api/notifications');
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'read_at' => now(),
        ]);
        $this->assertDatabaseHas('notifications', [
            'id' => $anotherNotification->id,
            'read_at' => now(),
        ]);
    }

    /** @test */
    public function it_should_mark_only_one_notification_if_its_id_is_passed()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create();
        $comment = $feed->comment([
            'body' => 'hello there',
            'user_id' => $user->id,
            'commentable_id' => $feed->id,
        ]);
        $notification = DatabaseNotification::create([
            'id' => Str::uuid(),
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'type' => 'database',
            'data' => [
                'id' => $feed->id,
                'link' => route('feeds.show', $feed->id),
                'message' => sprintf('%s commented on your feed', $comment->user->name),
            ],
        ]);
        $anotherNotification = DatabaseNotification::create([
            'id' => "ed55739d-c51b-4ee3-976f-6bfd0e8c1a81",
            'notifiable_id' => $user->id,
            'notifiable_type' => User::class,
            'type' => 'database',
            'data' => [
                'id' => $feed->id,
                'link' => route('feeds.show', $feed->id),
                'message' => sprintf('%s commented on your feed', $comment->user->name),
            ],
        ]);

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT', sprintf('/api/notifications/%s', $notification->id));
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'read_at' => now(),
        ]);
        $this->assertDatabaseMissing('notifications', [
            'id' => $anotherNotification->id,
            'read_at' => now(),
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->feedFactory = Feed::factory();
    }
}

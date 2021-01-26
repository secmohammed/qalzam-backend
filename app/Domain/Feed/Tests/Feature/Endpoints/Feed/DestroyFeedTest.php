<?php

namespace App\Domain\Feed\Tests\Feature\Endpoints\Feed;

use Tests\TestCase;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class DestroyFeedTest extends TestCase
{
    /** @test */
    public function it_should_delete_a_user_when_having_permissions_and_feeds_exist()
    {
        $user = $this->userFactory->create();
        $feeds = $this->feedFactory->count(2)->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $feeds->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.feeds.destroy', $ids)
        )->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_destroy_feed_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'DELETE',
            route('api.feeds.destroy', 10000)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_destroy_feed_if_not_having_permission_of_deleting_user()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.feeds.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_feed_if_unauthenticated()
    {
        $this->delete(
            route('api.feeds.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->feedFactory = Feed::factory();
    }
}

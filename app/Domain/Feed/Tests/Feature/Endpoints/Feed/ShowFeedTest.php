<?php

namespace App\Domain\Feed\Tests\Feature\Endpoints\Feed;

use Tests\TestCase;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class ShowFeedTest extends TestCase
{
    /** @test */
    public function it_should_see_feed_if_currently_active()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.show', $feed)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'longitude',
                'latitude',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_should_see_feed_with_his_comments_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->create();
        $feed->comment([
            'body' => 'hello',
            'commentable_id' => $feed->id,
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.show', $feed) . '?include=comments'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'longitude',
                'latitude',
                'comments',
                'created_at_human',
            ],
        ]);

    }

    /** @test */
    public function it_should_see_feed_with_his_user_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->create([
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.show', $feed) . '?include=user'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_see_feed_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.show', $feed)
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_see_feed_if_not_authenticated()
    {
        $feed = $this->feedFactory->create([
        ]);
        $this->get(
            route('api.feeds.show', $feed)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->feedFactory = Feed::factory();

    }
}

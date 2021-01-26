<?php

namespace App\Domain\Feed\Tests\Feature\Endpoints\Review;

use Tests\TestCase;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class DestroyFeedReviewTest extends TestCase
{
    /** @test */
    public function it_should_destroy_feed_review_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create([
        ]);
        $feed->createReview(5, null, $user);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.feeds.reviews.destroy', [$feed->id, $feed->reviews()->first()->id])
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_destroy_feed_review_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.feeds.reviews.destroy', [1, 1])
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_feed_review_if_unauthenticated()
    {
        $feed = $this->feedFactory->create([
        ]);
        $feed->createReview(5, null, $this->userFactory->create());
        $this->delete(
            route('api.feeds.reviews.destroy', [$feed->id, $feed->reviews()->first()->id])
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->feedFactory = Feed::factory();
    }
}

<?php

namespace App\Domain\Feed\Tests\Feature\Endpoints\Review;

use Faker\Factory;
use Tests\TestCase;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class UpdateFeedReviewTest extends TestCase
{
    /** @test */
    public function it_should_update_feed_review_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create([
        ]);
        $feed->createReview(5, null, $user);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.feeds.reviews.update', [$feed->id, $feed->reviews()->first()->id])
        )->assertStatus(200)->assertJsonStructure([
            'updated', 'review',
        ]);

    }

    /** @test */
    public function it_shouldnt_update_feed_review_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.feeds.reviews.update', [1, 1])
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_update_feed_review_if_unauthenticated()
    {
        $feed = $this->feedFactory->create([
        ]);
        $feed->createReview(5, null, $this->userFactory->create());
        $this->put(
            route('api.feeds.reviews.update', [$feed->id, $feed->reviews()->first()->id])
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->feedFactory = Feed::factory();
    }
}

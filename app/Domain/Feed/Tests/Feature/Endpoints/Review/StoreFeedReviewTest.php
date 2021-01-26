<?php

namespace App\Domain\Feed\Tests\Feature\Endpoints\Review;

use Tests\TestCase;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class StoreFeedReviewTest extends TestCase
{
    /** @test */
    public function it_should_let_user_store_feed_review()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'POST',
            route('api.feeds.reviews.store', $feed)
        )->assertJsonStructure(['created', 'review']);

    }

    /** @test */
    public function it_should_let_user_store_feed_review_with_body()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'POST',
            route('api.feeds.reviews.store', $feed), [
                'body' => 'hello12312312312',
            ]
        )->assertJsonStructure(['created', 'review']);
    }

    /** @test */
    public function it_should_let_user_store_feed_review_with_score()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'POST',
            route('api.feeds.reviews.store', $feed), [
                'score' => 3,
            ]
        )->assertJsonStructure(['created', 'review']);

    }

    /** @test */
    public function it_shouldnt_let_user_store_feed_review_above_score_5()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'POST',
            route('api.feeds.reviews.store', $feed), [
                'score' => 6,
            ]
        )->assertJsonValidationErrors(['score']);
    }

    /** @test */
    public function it_shouldnt_let_user_store_feed_review_less_than_score_1()
    {
        $user = $this->userFactory->create();
        $feed = $this->feedFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'POST',
            route('api.feeds.reviews.store', $feed), [
                'score' => 0,
            ]
        )->assertJsonValidationErrors(['score']);
    }

    /** @test */
    public function it_shouldnt_store_feed_review_if_feed_doesnt_exist()
    {
        $this->post(
            route('api.feeds.reviews.store', 100), []
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_store_feed_review_if_unauthenticated()
    {
        $feed = $this->feedFactory->create([
        ]);
        $this->post(
            route('api.feeds.reviews.store', $feed), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->feedFactory = Feed::factory();
        $this->userFactory = User::factory();
    }
}

<?php

namespace App\Domain\Feed\Tests\Feature\Endpoints\Feed;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Competition\Entities\Competition;

class StoreFeedTest extends TestCase
{
    /** @test */
    public function it_should_create_feed_with_check_in_type()
    {
        \Storage::fake();
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competition = $this->competitionFactory->create([
            'type' => 'check-in',
            'status' => 'active',
        ]);
        $feed = $this->feedFactory->make([
            'competition_id' => $competition->id,
            'latitude' => '18.979026',
            'longitude' => '19.766607',
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.feeds.store'), $feed->toArray()
        );
        $this->assertDatabaseMissing('media', [
            'model_id' => $response->getData(true)['data']['id'],
            'collection_name' => 'feed-isomorphic',
            'model_type' => Feed::class,
        ]);
        \Storage::assertMissing('public/' . $response->getData(true)['data']['id']);
    }

    /** @test */
    public function it_should_create_feed_with_image_type()
    {
        $user = $this->userFactory->create();
        $competition = $this->competitionFactory->create([
            'type' => 'image',
            'status' => 'active',
        ]);

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->make([
            'competition_id' => $competition->id,
            'feed-isomorphic' => [UploadedFile::fake()->image('file.png')],
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.feeds.store'), $feed->toArray()
        )->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'feed-isomorphic',
                'created_at_human',
            ],
        ]);

        $this->assertDatabaseHas('media', [
            'model_id' => $response->getData(true)['data']['id'],
            'collection_name' => 'feed-isomorphic',
            'model_type' => Feed::class,
        ]);

    }

    /** @test */
    public function it_should_create_feed_with_video_type()
    {
        $user = $this->userFactory->create();
        $competition = $this->competitionFactory->create([
            'type' => 'video',
            'status' => 'active',
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->make([
            'competition_id' => $competition->id,
            'feed-isomorphic' => [UploadedFile::fake()->create('file.mp4', 1024, 'video/mp4')],
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.feeds.store'), $feed->toArray()
        )->assertJsonStructure([
            'data' => [
                'id',
                'status',
                'feed-isomorphic',
                'created_at_human',
            ],
        ]);
        $this->assertDatabaseHas('media', [
            'model_id' => $response->getData(true)['data']['id'],
            'collection_name' => 'feed-isomorphic',
            'model_type' => Feed::class,
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_create_feed_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.feeds.store'), [
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_feed_if_unauthenticated()
    {
        $this->post(
            route('api.feeds.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->feedFactory = Feed::factory();
        $this->competitionFactory = Competition::factory();
    }
}

<?php

namespace App\Domain\Feed\Tests\Feature\Endpoints\Feed;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Competition\Entities\Competition;

class UpdateFeedTest extends TestCase
{
    /** @test */
    public function it_should_update_feed_with_check_in_type()
    {

        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competition = $this->competitionFactory->create([
            'type' => 'check-in',
            'status' => 'active',
        ]);
        $feed = $this->feedFactory->create([
            'competition_id' => $competition->id,
            'latitude' => '18.979026',
            'longitude' => '19.766607',
        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.feeds.update', $feed), $feed->toArray()
        );
        $this->assertDatabaseMissing('media', [
            'model_id' => $response->getData(true)['data']['id'],
            'collection_name' => 'feed-isomorphic',
            'model_type' => Feed::class,
        ]);
    }

    /** @test */
    public function it_should_update_feed_with_image_type()
    {
        $user = $this->userFactory->create();
        $competition = $this->competitionFactory->create([
            'type' => 'image',
            'status' => 'active',
        ]);

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->create([
            'competition_id' => $competition->id,

        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.feeds.update', $feed), $feed->toArray() + [
                'feed-isomorphic' => [UploadedFile::fake()->image('file.png')],
            ]
        )->assertStatus(200)->assertJsonStructure([
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
    public function it_should_update_feed_with_video_type()
    {
        $user = $this->userFactory->create();
        $competition = $this->competitionFactory->create([
            'type' => 'video',
            'status' => 'active',
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->create([
            'competition_id' => $competition->id,
        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.feeds.update', $feed), $feed->toArray() + [
                'feed-isomorphic' => [UploadedFile::fake()->create('file.mp4', 1024, 'video/mp4')],

            ]
        )->assertStatus(200)->assertJsonStructure([
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
    public function it_shouldnt_let_user_update_feed_if_doesnt_exist()
    {
        $this->put(
            route('api.feeds.update', 1), []
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_let_user_update_feed_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();

        $feed = $this->feedFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.feeds.update', $feed->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_feed_if_unauthenticated()
    {
        $feed = $this->feedFactory->create();
        $this->put(
            route('api.feeds.update', $feed->id), []
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

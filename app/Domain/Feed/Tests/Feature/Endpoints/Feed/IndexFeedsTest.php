<?php

namespace App\Domain\Feed\Tests\Feature\Endpoints\Feed;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class IndexFeedsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_feeds_filtered_by_competition_id()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->feedFactory->count(11)->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?filter[competition.id]=1'
        );
        $this->assertCount(1, $response->getData(true)['data']);
        $this->assertEquals(1, $response->getData(true)['data'][0]['competition_id']);
    }

    /** @test */
    public function it_should_fetch_feeds_with_child()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->feedFactory->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?include=child'
        );
        $this->assertTrue(array_key_exists('child', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_fetch_feeds_with_comments()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?include=comments'
        );
        $this->assertTrue(array_key_exists('comments', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_feeds_with_comments_and_its_replies()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->create([
            'status' => 'active',
        ]);
        $comment = $feed->comment([
            'user_id' => $user->id,
            'body' => 'Hello There',
            'commentable_id' => $feed->id,
        ]);
        $feed->comment([
            'user_id' => $user->id,
            'body' => 'Hello There',
            'commentable_id' => $feed->id,
            'parent_id' => $comment->id,
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?include=comments.children'
        );
        $this->assertTrue(array_key_exists('replies', $response->getData(true)['data'][0]['comments'][0]));

    }

    /** @test */
    public function it_should_fetch_feeds_with_competition()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->feedFactory->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?include=competition'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('competition', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_fetch_feeds_with_media()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $feed = $this->feedFactory->create([
            'status' => 'active',
        ]);
        $feed->addMedia(
            UploadedFile::fake()->image('file.png')
        )->toMediaCollection('feed-isomorphic');
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?include=media'
        );
        $this->assertTrue(array_key_exists('media', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_fetch_feeds_with_user()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->feedFactory->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_let_user_filter_feeds_by_child_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $feeds = $this->feedFactory->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?include=child&filter[filter_by_user_name_or_child_name]=' . $childName = $feeds->first()->child->name
        );
        $this->assertTrue(array_key_exists('child', $feed = $response->getData(true)['data'][0]));
        $this->assertEquals($childName, $feed['child']['name']);

    }

    /** @test */
    public function it_should_let_user_filter_feeds_by_status()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->feedFactory->count(3)->create([
            'status' => 'disqualified',
        ]);
        $this->feedFactory->create([
            'status' => $status = 'pending',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?filter[status]=' . $status
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_let_user_filter_feeds_by_user_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $feeds = $this->feedFactory->count(3)->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?include=user&filter[filter_by_user_name_or_child_name]=' . $username = $feeds->first()->user->name
        );
        $this->assertTrue(array_key_exists('user', $feed = $response->getData(true)['data'][0]));
        $this->assertEquals($username, $feed['user']['name']);

    }

    /** @test */
    public function it_should_sort_feeds_by_created_at_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->feedFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $this->feedFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $this->feedFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_feeds_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->feedFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $this->feedFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'pending',

        ]);
        $this->feedFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),

            'status' => 'pending',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_feeds_by_top_rated()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $anotherFeed = $this->feedFactory->create([
            'status' => 'active',
        ]);
        $feed = $this->feedFactory->create([
            'status' => 'active',
        ]);
        $topFeed = $this->feedFactory->create([
            'status' => 'active',
        ]);
        $topFeed->createReview(5, null, $user);
        $topFeed->comment([
            'user_id' => $user->id,
            'body' => 'Hello There',
            'commentable_id' => $topFeed->id,
        ]);
        $topFeed->comment([
            'user_id' => $user->id,
            'body' => 'Hello There',
            'commentable_id' => $topFeed->id,
        ]);
        $topFeed->comment([
            'user_id' => $user->id,
            'body' => 'Hello There',
            'commentable_id' => $topFeed->id,
        ]);
        $feed->createReview(5, null, $user);
        $feed->comment([
            'user_id' => $user->id,
            'body' => 'Hello There',
            'commentable_id' => $topFeed->id,
        ]);

        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.feeds.index') . '?filter[sort_by_top_rated]'
        );
        $this->assertEquals($topFeed->id, $response->getData(true)['data']['0']['id']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->feedFactory = Feed::factory();

    }
}

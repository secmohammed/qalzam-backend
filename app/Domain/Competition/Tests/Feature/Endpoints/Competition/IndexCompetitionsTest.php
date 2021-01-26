<?php

namespace App\Domain\Competition\Tests\Feature\Endpoints\Competition;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\Feed\Entities\Feed;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Location\Entities\Location;
use App\Domain\Competition\Entities\Competition;

class IndexCompetitionsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_active_competitions()
    {
        $activeCompetitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'end_date' => now()->addMonths(1),
        ]);
        $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'end_date' => now()->subMonths(1),
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competitions = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[active_competitions]'
        )->getData(true)['data'];
        $this->assertCount(3, $competitions);
        foreach ($competitions as $competition) {
            $this->assertTrue(Carbon::parse($competition['end_date'])->gt(now()));
        }

    }

    /** @test */
    public function it_should_fetch_competition_with_location_when_loaded()
    {
        $this->competitionFactory->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competitions = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?include=location'
        )->getData(true)['data'];
        $this->assertTrue(array_key_exists('location', $competitions[0]));
    }

    /** @test */
    public function it_should_fetch_competitions_by_location_and_its_children()
    {
        $location = $this->locationFactory->create();
        $childLocation = $this->locationFactory->create([
            'parent_id' => $location->id,
        ]);
        $grandChildLocation = $this->locationFactory->create([
            'parent_id' => $childLocation->id,
        ]);
        $nonRelevantLocation = $this->locationFactory->create();
        $competition = $this->competitionFactory->create([
            'location_id' => $location->id,
            'status' => 'active',
        ]);
        $anotherCompetition = $this->competitionFactory->create([
            'location_id' => $grandChildLocation->id,
            'status' => 'active',

        ]);
        $nonRelevantCompetition = $this->competitionFactory->create([
            'location_id' => $nonRelevantLocation->id,
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competitions = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[filter_by_location_and_its_children]=' . $location->id
        )->getData(true)['data'];
        $this->assertCount(2, $competitions);

    }

    /** @test */
    public function it_should_fetch_competitions_with_children()
    {
        $competitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
        ]);

        $locations = Location::factory()->count(3)->create();
        $competitions->each(function ($competition) use ($locations) {
            $competition->children()->attach($children = Child::factory()->count(3)->create([
                'status' => 'active',
                'location_id' => $locations->random()->id,
            ]));
            $competition->feeds()->saveMany(Feed::factory()->count(3)->make([
                'child_id' => $children->random()->id,
            ]));
        });
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->count(3)->withChildren(3, [
            'status' => 'active',
        ])->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?include=children'
        );
        $this->assertTrue(array_key_exists('participants', $response->getData(true)['data'][0]));
        $this->assertCount(3, $response->getData(true)['data'][0]['participants']);
    }

    /** @test */
    public function it_should_fetch_competitions_with_feeds()
    {
        $this->competitionFactory->count(3)->withFeeds(3, [
            'status' => 'active',
        ])->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?include=feeds'
        );

        $this->assertTrue(array_key_exists('feeds', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_competitions_with_gender_type_both()
    {
        $maleCompetitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'gender' => 'male',
        ]);
        $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'gender' => 'female',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competitions = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[gender]=both'
        )->getData(true)['data'];
        $this->assertCount(6, $competitions);

    }

    /** @test */
    public function it_should_fetch_competitions_with_gender_type_male()
    {
        $maleCompetitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'gender' => 'male',
        ]);
        $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'gender' => 'female',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competitions = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[gender]=male'
        )->getData(true)['data'];
        $this->assertCount(3, $competitions);
        foreach ($competitions as $competition) {
            $this->assertEquals('male', $competition['gender']);
        }

    }

    /** @test */
    public function it_should_fetch_competitions_with_media()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $competition = $this->competitionFactory->create([
            'status' => 'active',
        ]);
        $competition->addMedia(
            UploadedFile::fake()->image('file.png')
        )->toMediaCollection('competition-cover');
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?include=media'
        );
        $this->assertTrue(array_key_exists('media', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_fetch_competitions_with_top_rated_feeds()
    {
        $competitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $competitions->each(function ($competition) use ($user) {
            $competition->children()->attach($children = Child::factory()->count(2)->create([
                'status' => 'active',
            ]));

            Feed::factory()->create([
                'child_id' => $children->first()->id,
                'competition_id' => $competition->id,
                'status' => 'active',
            ]);
            Feed::factory()->create([
                'child_id' => $children->last()->id,
                'competition_id' => $competition->id,
                'status' => 'active',

            ]);
            $competition->feeds->each(function ($feed, $index) use ($user) {
                $feed->createReview(5, null, $user);
                $feed->comment([
                    'user_id' => $user->id,
                    'body' => 'Hello There',
                    'commentable_id' => $feed->id,

                ]);
                if ($index) {
                    $feed->comment([
                        'user_id' => $user->id,
                        'body' => 'Hello There',
                        'commentable_id' => $feed->id,

                    ]);
                    $feed->comment([
                        'user_id' => $user->id,
                        'body' => 'Hello There',
                        'commentable_id' => $feed->id,

                    ]);

                }
            });
        });
        $competitions = $this->jsonAs($user, 'GET', route('api.competitions.index') . '?filter[with_top_rated_participants]')->getData(true)['data'];
        $this->assertCount(3, $competitions);
        $this->assertEquals(3, $competitions[0]['feeds'][0]['comments_count']);
        $this->assertEquals(1, $competitions[0]['feeds'][0]['likes_count']);
        $this->assertEquals(1, $competitions[0]['feeds'][1]['comments_count']);
        $this->assertEquals(1, $competitions[0]['feeds'][1]['likes_count']);
    }

    /** @test */
    public function it_should_fetch_competitions_with_user()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->count(3)->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_fetch_featured_competitions()
    {
        $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'featured' => 'featured',
        ]);
        $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'featured' => 'normal',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competitions = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[featured]=featured'
        )->getData(true)['data'];
        $this->assertCount(3, $competitions);

    }

    /** @test */
    public function it_should_fetch_previous_competitions()
    {
        $activeCompetitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'end_date' => now()->addMonths(1),
        ]);
        $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'end_date' => now()->subMonths(1),
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competitions = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[previous_competitions]'
        )->getData(true)['data'];
        $this->assertCount(3, $competitions);
        foreach ($competitions as $competition) {
            $this->assertTrue(Carbon::parse($competition['end_date'])->lt(now()));
        }
    }

    /** @test */
    public function it_should_fetch_user_competitions()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $competitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->competitionFactory->count(3)->create([
            'status' => 'active',
        ]);

        $competitions->each(function ($competition) use ($user) {
            $competition->children()->attach($children = Child::factory()->count(3)->create([
                'status' => 'active',
                'user_id' => $user->id,
            ]));
            $competition->feeds()->saveMany(Feed::factory()->count(3)->make([
                'child_id' => $children->random()->id,
                'user_id' => $user->id,
            ]));
        });
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[my_competitions]'
        );
        $this->assertCount(3, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_filter_competitions_by_age_range()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->competitionFactory->count(2)->withStatus('active')->create([
            'min_age' => 10,
            'max_age' => 20,
        ]);
        $this->competitionFactory->withStatus('active')->create([
            'max_age' => 20,
            'min_age' => 15,
        ]);
        $this->competitionFactory->count(3)->withStatus('active')->create([
            'max_age' => 20,
            'min_age' => 5,
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[age_between]=10,20'
        );
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_competitions_by_start_date_and_end_date_range()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->withStatus('active')->create([
            'start_date' => '2020-10-10 10:45',
            'end_date' => '2020-10-10 12:00',
        ]);
        $this->competitionFactory->withStatus('active')->create([
            'start_date' => '2020-10-13 10:45',
            'end_date' => '2020-10-13 12:00',
        ]);
        $this->competitionFactory->withStatus('active')->create([
            'start_date' => '2020-10-15 10:45',
            'end_date' => '2020-10-15 12:00',
        ]);
        $this->competitionFactory->withStatus('active')->create([
            'start_date' => '2020-10-11 10:45',
            'end_date' => '2020-10-11 12:00',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[date_between]=2020-10-10,2020-10-13'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);

    }

    /** @test */
    public function it_should_filter_competitions_with_popular_participants_based_on_locations()
    {
        $competitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $location = Location::factory()->create();
        $otherCompetitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
        ])->each(function ($competition) {
            $competition->children()->attach(
                Child::factory()->count(2)->create([
                    'status' => 'active',
                ])
            );

        });
        $competitions->each(function ($competition) use ($location, $user) {
            $competition->children()->attach($children = Child::factory()->count(2)->create([
                'status' => 'active',
                'location_id' => $location->id,
            ]));

            Feed::factory()->create([
                'child_id' => $children->first()->id,
                'competition_id' => $competition->id,
            ]);
            Feed::factory()->create([
                'child_id' => $children->last()->id,
                'competition_id' => $competition->id,
            ]);

            $competition->feeds->each(function ($feed, $index) use ($user) {
                $feed->createReview(5, null, $user);
                $feed->comment([
                    'user_id' => $user->id,
                    'body' => 'Hello There',
                    'commentable_id' => $feed->id,

                ]);
                if ($index) {
                    $feed->comment([
                        'user_id' => $user->id,
                        'body' => 'Hello There',
                        'commentable_id' => $feed->id,

                    ]);
                    $feed->comment([
                        'user_id' => $user->id,
                        'body' => 'Hello There',
                        'commentable_id' => $feed->id,

                    ]);

                }
            });
        });
        $competitions = $this->jsonAs($user, 'GET', route('api.competitions.index') . '?filter[with_popular_participants_based_on_location]=' . $location->id)->getData(true)['data'];
        $this->assertCount(3, $competitions);
        $this->assertEquals(3, $competitions[0]['feeds'][0]['comments_count']);
        $this->assertEquals(1, $competitions[0]['feeds'][0]['likes_count']);
        $this->assertEquals(1, $competitions[0]['feeds'][1]['comments_count']);
        $this->assertEquals(1, $competitions[0]['feeds'][1]['likes_count']);

    }

    /** @test */
    public function it_should_has_is_joined_attribute_when_children_relation_loaded()
    {
        $competitions = $this->competitionFactory->count(3)->create([
            'status' => 'active',
        ]);

        $locations = Location::factory()->count(3)->create();
        $competitions->each(function ($competition) use ($locations) {
            $competition->children()->attach($children = Child::factory()->count(3)->create([
                'status' => 'active',
                'location_id' => $locations->random()->id,
            ]));
            $competition->feeds()->saveMany(Feed::factory()->count(3)->make([
                'child_id' => $children->random()->id,
            ]));
        });
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->count(3)->withChildren(3, [
            'status' => 'active',
        ])->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?include=children'
        );

        $this->assertTrue(array_key_exists('is_joined', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_let_user_filter_competitions_by_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->competitionFactory->create([
            'name' => $name = 'mohammed',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[name]=' . $name
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_let_user_filter_competitions_by_type()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->count(3)->create([
            'status' => 'active',
            'type' => 'video',
        ]);
        $this->competitionFactory->count(2)->create([
            'type' => $type = 'image',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?filter[type]=' . $type
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(2, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_sort_competitions_by_created_at_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_competitions_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),

            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_competitions_by_end_date_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->create([
            'end_date' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',
        ]);
        $this->competitionFactory->create([
            'end_date' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'end_date' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?sort=end_date'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->toDayDateTimeString(),
            $response->getData(true)['data'][0]['end_date']
        );
    }

    /** @test */
    public function it_should_sort_competitions_by_end_date_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->create([
            'end_date' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'end_date' => now()->subDays(2)->format('Y-m-d'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'end_date' => now()->subDays(3)->format('Y-m-d'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?sort=-end_date'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->toDayDateTimeString(),
            $response->getData(true)['data'][0]['end_date']
        );
    }

    /** @test */
    public function it_should_sort_competitions_by_start_date_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->create([
            'start_date' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',
        ]);
        $this->competitionFactory->create([
            'start_date' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'start_date' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?sort=start_date'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->toDayDateTimeString(),
            $response->getData(true)['data'][0]['start_date']
        );
    }

    /** @test */
    public function it_should_sort_competitions_by_start_date_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->competitionFactory->create([
            'start_date' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'start_date' => now()->subDays(2)->format('Y-m-d'),
            'status' => 'active',

        ]);
        $this->competitionFactory->create([
            'start_date' => now()->subDays(3)->format('Y-m-d'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.index') . '?sort=-start_date'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->toDayDateTimeString(),
            $response->getData(true)['data'][0]['start_date']
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->competitionFactory = Competition::factory();
        $this->locationFactory = Location::factory();

    }
}

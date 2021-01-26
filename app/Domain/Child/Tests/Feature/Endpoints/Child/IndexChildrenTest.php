<?php

namespace App\Domain\Child\Tests\Feature\Endpoints\Child;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;

class IndexChildrenTest extends TestCase
{
    /** @test */
    public function it_should_fetch_children_with_competitions()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->count(3)->withCompetitions(3, [
            'status' => 'active',
        ])->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?include=competitions'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('competitions', $response->getData(true)['data'][0]));
        $this->assertCount(3, $response->getData(true)['data'][0]['competitions']);
    }

    /** @test */
    public function it_should_fetch_children_with_user()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->count(3)->withStatus('active')->create();
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?include=user'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));
    }

    /** @test */
    public function it_should_let_user_filter_children_by_birthdate()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->childFactory->count(2)->create([
            'birthdate' => $birthdate = '1997-06-29',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?filter[birthdate]=' . $birthdate
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(2, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_let_user_filter_children_by_gender()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->count(3)->create([
            'status' => 'active',
            'gender' => 'female',
        ]);
        $this->childFactory->count(2)->create([
            'gender' => $gender = 'male',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?filter[gender]=' . $gender
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(2, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_let_user_filter_children_by_name()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->count(3)->create([
            'status' => 'active',
        ]);
        $this->childFactory->count(2)->create([
            'name' => $name = 'mohammed',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?filter[name]=' . $name
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(2, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_let_user_filter_children_by_relation()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->count(3)->create([
            'status' => 'active',
            'relation' => 'son',
        ]);
        $this->childFactory->count(2)->create([
            'relation' => $relation = 'daughter',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?filter[relation]=' . $relation
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(2, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_let_user_filter_children_by_their_parent()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->count(3)->create([
            'status' => 'active',
            'user_id' => $user->id,
        ]);
        $this->childFactory->count(2)->create([
            'birthdate' => $birthdate = '1997-06-29',
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?filter[user.id]=' . $user->id
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_sort_children_by_birthdate_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->create([
            'birthdate' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',
        ]);
        $this->childFactory->create([
            'birthdate' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->childFactory->create([
            'birthdate' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?sort=birthdate'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->format('Y-m-d'),
            $response->getData(true)['data'][0]['birthdate']
        );
    }

    /** @test */
    public function it_should_sort_children_by_birthdate_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->create([
            'birthdate' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d'),
            'status' => 'active',

        ]);
        $this->childFactory->create([
            'birthdate' => now()->subDays(2)->format('Y-m-d'),
            'status' => 'active',

        ]);
        $this->childFactory->create([
            'birthdate' => now()->subDays(3)->format('Y-m-d'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?sort=-birthdate'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->format('Y-m-d'),
            $response->getData(true)['data'][0]['birthdate']
        );
    }

    /** @test */
    public function it_should_sort_children_by_created_at_ascending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->childFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->childFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_children_by_created_at_descending()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->childFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->childFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->childFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),

            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $user,
            'GET',
            route('api.children.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->childFactory = Child::factory();

    }
}

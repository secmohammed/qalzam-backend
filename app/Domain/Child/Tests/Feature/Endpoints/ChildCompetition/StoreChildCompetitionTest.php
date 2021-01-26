<?php

namespace App\Domain\Child\Tests\Feature\Endpoints\ChildCompetition;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use App\Domain\Child\Entities\Child;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Location\Entities\Location;
use App\Domain\Competition\Entities\Competition;

class StoreChildCompetitionTest extends TestCase
{
    /** @test */
    public function it_should_let_user_attach_competition_to_children_if_both_exists()
    {
        $competition = $this->competitionFactory->withStatus('active')->create([
            'max_age' => $max = 15,
            'min_age' => $min = 8,
            'gender' => 'male',
            'location_id' => $location = $this->locationFactory->withStatus('active')->create(),

        ]);
        $children = $this->childFactory->withStatus('active')->count(3)->create([
            'birthdate' => now()->subYears(($max + $min) / 2),
            'gender' => 'male',
            'location_id' => $location->id,
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST', route('api.competitions.children.store', compact('competition')), [
            'children' => $children->pluck('id')->toArray(),
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'type',
                'status',
                'cover_photo',
                'start_date',
                'end_date',
                'min_age',
                'max_age',
                'created_at_human',
            ],
        ]);
        foreach ($children as $child) {
            $this->assertDatabaseHas('child_competition', [
                'child_id' => $child->id,
                'competition_id' => $competition->id,
            ]);

        }
    }

    /** @test */
    public function it_should_let_user_attach_his_child_no_matter_his_gender_if_competition_has_type_of_both_for_gender()
    {
        $competition = $this->competitionFactory->withStatus('active')->create([
            'max_age' => $max = 15,
            'min_age' => $min = 8,
            'gender' => 'both',
            'location_id' => $location = $this->locationFactory->withStatus('active')->create(),
        ]);
        $children = $this->childFactory->withStatus('active')->count(3)->create([
            'birthdate' => now()->subYears(($max + $min) / 2),
            'gender' => 'male',
            'location_id' => $location->id,
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST', route('api.competitions.children.store', compact('competition')), [
            'children' => $children->pluck('id')->toArray(),
        ])->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'type',
                'status',
                'cover_photo',
                'start_date',
                'end_date',
                'min_age',
                'max_age',
                'created_at_human',
            ],
        ]);
        foreach ($children as $child) {
            $this->assertDatabaseHas('child_competition', [
                'child_id' => $child->id,
                'competition_id' => $competition->id,
            ]);

        }
    }

    /** @test */
    public function it_shouldnt_let_user_attach_competition_to_child_if_child_doesnt_exist()
    {
        $competition = $this->competitionFactory->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs(
            $user,
            'POST',
            route('api.competitions.children.store', [
                'competition' => $competition,
            ]),
            [1]
        )->assertStatus(422);
    }

    /** @test */
    public function it_shouldnt_let_user_attach_competition_to_child_if_competition_doesnt_exist()
    {

        $this->post(
            route('api.competitions.children.store', [
                'competition' => 1,
            ])
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_attach_competition_to_child_if_not_authenticated()
    {
        $competition = $this->competitionFactory->create([
            'status' => 'active',
            'location_id' => $location = $this->locationFactory->withStatus('active')->create(),

        ]);
        $child = $this->childFactory->withStatus('active')->create([

            'location_id' => $location->id,
        ]);
        $this->post(
            route('api.competitions.children.store', compact('competition'))
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_attach_his_child_to_competition_if_age_is_above_competition_maximum_age()
    {
        $competition = $this->competitionFactory->withStatus('active')->create([
            'max_age' => $max = 15,
            'min_age' => $min = 8,
            'gender' => 'female',
            'location_id' => $location = $this->locationFactory->withStatus('active')->create(),

        ]);
        $children = $this->childFactory->withStatus('active')->count(3)->create([
            'birthdate' => now()->subYears($max + 2),
            'gender' => 'female',
            'location_id' => $location->id,
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST', route('api.competitions.children.store', compact('competition')), [
            'children' => $children->pluck('id')->toArray(),
        ])->assertStatus(422)->assertJson([
            'message' => sprintf('The competition requires min age of %d and max age of %d to participate', $competition->min_age, $competition->max_age),
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_attach_his_child_to_competition_if_age_is_below_competition_minimum_age()
    {
        $competition = $this->competitionFactory->withStatus('active')->create([
            'max_age' => $max = 15,
            'min_age' => $min = 8,
            'gender' => 'female',
            'location_id' => $location = $this->locationFactory->withStatus('active')->create(),

        ]);
        $children = $this->childFactory->withStatus('active')->count(3)->create([
            'birthdate' => now()->subYears($min - 2),
            'gender' => 'female',
            'location_id' => $location->id,

        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST', route('api.competitions.children.store', compact('competition')), [
            'children' => $children->pluck('id')->toArray(),
        ])->assertStatus(422)->assertJson([
            'message' => sprintf('The competition requires min age of %d and max age of %d to participate', $competition->min_age, $competition->max_age),
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_attach_his_child_to_competition_if_child_location_isnt_same_as_competition_location()
    {
        $competition = $this->competitionFactory->withStatus('active')->create([
            'location_id' => $location = $this->locationFactory->withStatus('active')->create(),
        ]);
        $children = $this->childFactory->withStatus('active')->count(3)->create([
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST', route('api.competitions.children.store', compact('competition')), [
            'children' => $children->pluck('id')->toArray(),
        ])->assertStatus(422)->assertJson([
            'message' => sprintf('The child is not located at %s to participate at the competition', $location->name),
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_attach_his_child_to_competition_if_gender_isnt_same_as_competition_gender()
    {
        $competition = $this->competitionFactory->withStatus('active')->create([
            'max_age' => $max = 15,
            'min_age' => $min = 8,
            'gender' => 'male',
            'location_id' => $location = $this->locationFactory->withStatus('active')->create(),

        ]);
        $children = $this->childFactory->withStatus('active')->count(3)->create([
            'birthdate' => now()->subYears(($max + $min) / 2),
            'gender' => 'female',
            'location_id' => $location->id,
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'POST', route('api.competitions.children.store', compact('competition')), [
            'children' => $children->pluck('id')->toArray(),
        ])->assertStatus(422)->assertJson([
            'message' => sprintf('The competition requires gender of %s to participate', $competition->gender),
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_create_competition_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.competitions.store'), [
            ]
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->childFactory = Child::factory();
        $this->competitionFactory = Competition::factory();
        $this->userFactory = User::factory();
        $this->locationFactory = Location::factory();
    }
}

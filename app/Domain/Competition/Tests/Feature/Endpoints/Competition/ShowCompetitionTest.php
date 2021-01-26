<?php

namespace App\Domain\Competition\Tests\Feature\Endpoints\Competition;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Competition\Entities\Competition;

class ShowCompetitionTest extends TestCase
{
    /** @test */
    public function it_should_see_competition_if_currently_active()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competition = $this->competitionFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.show', $competition)
        )->assertStatus(200)->assertJsonStructure([
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
    }

    /** @test */
    public function it_should_see_competition_with_his_user_when_loaded()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competition = $this->competitionFactory->create([
            'status' => 'active',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.show', $competition) . '?include=user'
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_see_competition_if_currently_inactive()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competition = $this->competitionFactory->create([
            'status' => 'inactive',
        ]);
        $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.show', $competition)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_see_competition_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $competition = $this->competitionFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.competitions.show', $competition)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->competitionFactory = Competition::factory();

    }
}

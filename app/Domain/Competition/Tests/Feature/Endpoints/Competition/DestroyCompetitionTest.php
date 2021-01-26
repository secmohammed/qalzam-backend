<?php

namespace App\Domain\Competition\Tests\Feature\Endpoints\Competition;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Competition\Entities\Competition;

class DestroyCompetitionTest extends TestCase
{
    /** @test */
    public function it_should_delete_a_user_when_having_permissions_and_competitions_exist()
    {
        $user = $this->userFactory->create();
        $competitions = $this->competitionFactory->count(2)->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $ids = implode(',', $competitions->pluck('id')->toArray());

        $this->jsonAs($user, 'DELETE',
            route('api.competitions.destroy', $ids)
        )->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_destroy_competition_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'DELETE',
            route('api.competitions.destroy', 10000)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_destroy_competition_if_not_having_permission_of_deleting_user()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.competitions.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_competition_if_unauthenticated()
    {
        $this->delete(
            route('api.competitions.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->competitionFactory = Competition::factory();
    }
}

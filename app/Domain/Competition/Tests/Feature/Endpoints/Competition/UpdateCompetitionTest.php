<?php

namespace App\Domain\Competition\Tests\Feature\Endpoints\Competition;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Competition\Entities\Competition;

class UpdateCompetitionTest extends TestCase
{
    /** @test */
    public function it_should_update_competition()
    {
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competition = $this->competitionFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.competitions.update', $competition), $competition->toArray()
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
    public function it_should_update_competition_with_cover_photo()
    {
        \Storage::fake('local');
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competition = $this->competitionFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs($user, 'PUT',
            route('api.competitions.update', $competition), $competition->toArray() + [
                'competition-cover' => UploadedFile::fake()->image('image.jpg'),

            ]
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
        $this->assertDatabaseHas('media', [
            'model_id' => $competition->id,
            'collection_name' => 'competition-cover',
            'model_type' => Competition::class,
        ]);
    }

    /** @test */
    public function it_shouldnt_let_user_update_competition_if_doesnt_exist()
    {
        $this->put(
            route('api.competitions.update', 1), []
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_let_user_update_competition_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();

        $competition = $this->competitionFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.competitions.update', $competition->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_competition_if_unauthenticated()
    {
        $competition = $this->competitionFactory->create([
            'status' => 'active',
        ]);
        $this->put(
            route('api.competitions.update', $competition->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->competitionFactory = Competition::factory();
    }
}

<?php

namespace App\Domain\Competition\Tests\Feature\Endpoints\Competition;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Competition\Entities\Competition;

class StoreCompetitionTest extends TestCase
{
    /** @test */
    public function it_should_create_competition()
    {
        \Storage::fake('competition-cover');
        $user = $this->userFactory->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $competition = $this->competitionFactory->make([
            'competition-cover' => UploadedFile::fake()->image('image.jpg'),
            'name_ar' => 'whatever-name',
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.competitions.store'), $competition->toArray()
        )->assertStatus(201)->assertJsonStructure([
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
            'model_id' => $response->getData(true)['data']['id'],
            'collection_name' => 'competition-cover',
            'model_type' => Competition::class,
        ]);
        \Storage::assertExists('public/1/image.jpg');
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

    /** @test */
    public function it_shouldnt_store_competition_if_unauthenticated()
    {
        $this->post(
            route('api.competitions.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->competitionFactory = Competition::factory();
    }
}

<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints\Accommodation;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Accommodation\Entities\Accommodation;

class ShowAccommodationTest extends TestCase
{
    /** @test */
    public function it_should_fetch_accommodation_by_id_if_authenticated_and_has_permissions()
    {
        $accommodation = $this->accommodationFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'GET',
            route('api.accommodations.show', $accommodation->id)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'name',
                'id',
                'code',
                'branch_id',
                'contract_id',
                'user_id',
                'capacity',
                'media',
                'created_at_human',
                'type',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_fetch_accommodation_by_id_if_not_found()
    {
        $this->get(
            route('api.accommodations.show', 100)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_fetch_accommodation_if_not_authenticated()
    {
        $accommodation = $this->accommodationFactory->create();
        $this->get(
            route('api.accommodations.show', $accommodation->id)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_fetch_brnach_if_authenticated_but_doesnt_have_permissions()
    {
        $accommodation = $this->accommodationFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.accommodations.show', $accommodation->id)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->accommodationFactory = Accommodation::factory();
        $this->userFactory = User::factory();
    }
}

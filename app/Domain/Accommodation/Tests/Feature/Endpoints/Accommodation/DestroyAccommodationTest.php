<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints\Accommodation;

use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Branch\Entities\Branch;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use Joovlly\Authorizable\Models\Role;
use Tests\TestCase;

class DestroyAccommodationTest extends TestCase
{
    /** @test */
    public function it_should_delete_accommodation_when_branch_is_deleted()
    {
        $user = $this->userFactory->create();
        $accommodation = $this->accommodationFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        Branch::whereId($accommodation->branch_id)->delete();
        $this->assertDatabaseMissing('accommodations', [
            'id' => $accommodation->id,
            'name' => $accommodation->name,
        ]);
    }

    /** @test */
    public function it_should_delete_accommodation_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $accommodation = $this->accommodationFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.accommodations.destroy', $accommodation->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_destroy_accommodation_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.accommodations.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_accommodation_if_not_having_permission_of_deleting_accommodation()
    {
        $accommodation = $this->accommodationFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.accommodations.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_accommodation_if_unauthenticated()
    {
        $this->delete(
            route('api.accommodations.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->accommodationFactory = Accommodation::factory();
    }
}

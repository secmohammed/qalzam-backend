<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Branch;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Location\Entities\Location;

class DestroyBranchTest extends TestCase
{
    /** @test */
    public function it_should_delete_branch_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $branch = $this->branchFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.branches.destroy', $branch->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_should_delete_branch_when_location_is_deleted()
    {
        $user = $this->userFactory->create();
        $branch = $this->branchFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        Location::whereId($branch->location_id)->delete();
        $this->assertDatabaseMissing('branches', [
            'id' => $branch->id,
            'name' => $branch->name,
        ]);
    }

    /** @test */
    public function it_shouldnt_destroy_branch_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.branches.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_branch_if_not_having_permission_of_deleting_branch()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.branches.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_branch_if_unauthenticated()
    {
        $this->delete(
            route('api.branches.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->branchFactory = Branch::factory();
    }
}

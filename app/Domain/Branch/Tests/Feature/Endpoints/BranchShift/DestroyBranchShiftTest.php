<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\BranchShift;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Branch\Entities\BranchShift;

class DestroyBranchShiftTest extends TestCase
{
    /** @test */
    public function it_should_delete_branch_shift_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $shift = $this->branchShiftFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.branch_shifts.destroy', $shift->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_should_delete_branch_shift_when_shift_is_deleted()
    {
        $user = $this->userFactory->create();
        $shift = $this->branchShiftFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        Branch::whereId($shift->branch_id)->delete();
        $this->assertDatabaseMissing('branch_shifts', [
            'id' => $shift->id,
            'day' => $shift->day,
            'branch_id' => $shift->branch_id,
        ]);
    }

    /** @test */
    public function it_shouldnt_destroy_branch_shift_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.branch_shifts.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_branch_shift_if_not_having_permission_of_deleting_branch_shift()
    {
        $shift = $this->branchShiftFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.branch_shifts.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_branch_shift_if_unauthenticated()
    {
        $this->delete(
            route('api.branch_shifts.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->branchShiftFactory = BranchShift::factory();
    }
}

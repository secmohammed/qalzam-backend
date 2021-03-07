<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\BranchShift;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Branch\Entities\BranchShift;

class UpdateBranchShiftTest extends TestCase
{
    /** @test */
    public function it_should_update_branch_shift()
    {
        $shift = $this->branchShiftFactory->create([
            'status' => 'active',
            'day' => 'sunday',
        ]);

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.branch_shifts.update', $shift->id), [
                'day' => 'monday',
            ] + $shift->toArray()
        )->assertStatus(200);
    }

    /** @test */
    public function it_shouldnt_let_user_update_branch_shift_if_doesnt_exist()
    {
        $this->put(
            route('api.branch_shifts.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_branch_shift_if_doesnt_have_permission()
    {
        $shift = $this->branchShiftFactory->create([
            'status' => 'active',

        ]);

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.branch_shifts.update', $shift->id), [
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_branch_shift_if_unauthenticated()
    {
        $shift = $this->branchShiftFactory->create([
            'status' => 'active',
        ]);
        $this->put(
            route('api.branch_shifts.update', $shift->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->branchShiftFactory = BranchShift::factory();
    }
}

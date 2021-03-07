<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\BranchShift;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Branch\Entities\BranchShift;

class StoreBranchShiftTest extends TestCase
{
    /** @test */
    public function it_should_let_user_create_branch_shift()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $shift = $this->branchShiftFactory->make([
        ]);

        $response = $this->jsonAs($user, 'POST',
            route('api.branch_shifts.store'), $shift->toArray() + [

            ]
        )->assertStatus(201);
    }

    /** @test */
    public function it_shouldnt_let_user_create_branch_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.branch_shifts.store'), [
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_store_branch_if_unauthenticated()
    {
        $this->post(
            route('api.branch_shifts.store'), []
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_store_branch_shift_if_shift_day_already_exists_for_branch_and_active()
    {
        $shift = $this->branchShiftFactory->create([
            'status' => 'active',
            'day' => 'monday',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $shift = $this->branchShiftFactory->make([
            'day' => 'monday',
            'branch_id' => $shift->branch_id,
        ]);
        $this->jsonAs($user, 'POST',
            route('api.branch_shifts.store'), $shift->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['branch_id']);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->branchShiftFactory = BranchShift::factory();
    }
}

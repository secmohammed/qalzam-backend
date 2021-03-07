<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\BranchShift;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Branch\Entities\BranchShift;

class ShowBranchShiftTest extends TestCase
{
    /** @test */
    public function it_should_fetch_branch_by_id_if_authenticated_and_has_permissions()
    {
        $shift = $this->branchShiftFactory->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'GET',
            route('api.branch_shifts.show', $shift->id)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'user_id',
                'day',
                'branch_id',
                'start_time',
                'end_time',
                'created_at_human',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_fetch_branch_by_id_if_not_found()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs(
            $user,
            'GET',
            route('api.branch_shifts.show', 100)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_fetch_branch_if_not_authenticated()
    {
        $shift = $this->branchShiftFactory->create([
            'status' => 'active',
        ]);
        $this->get(
            route('api.branch_shifts.show', $shift->id)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_fetch_brnach_if_authenticated_but_doesnt_have_permissions()
    {
        $shift = $this->branchShiftFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.branch_shifts.show', $shift->id)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->branchShiftFactory = BranchShift::factory();
        $this->userFactory = User::factory();
    }
}

<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;

class ShowBranchTest extends TestCase
{
    /** @test */
    public function it_should_fetch_branch_by_id_if_authenticated_and_has_permissions()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'GET',
            route('api.branches.show', $branch->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_fetch_branch_by_id_if_not_found()
    {
        $this->get(
            route('api.branches.show', 100)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_fetch_branch_if_not_authenticated()
    {
        $branch = $this->branchFactory->create();
        $this->get(
            route('api.branches.show', $branch->id)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_fetch_brnach_if_authenticated_but_doesnt_have_permissions()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.branches.show', $branch->id)
        )->assertStatus(401);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->branchFactory = Branch::factory();
        $this->userFactory = User::factory();
    }
}

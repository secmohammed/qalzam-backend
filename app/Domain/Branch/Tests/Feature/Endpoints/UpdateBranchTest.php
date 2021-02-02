<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;

class UpdateBranchTest extends TestCase
{
    /** @test */
    public function it_should_update_branch_with_gallery()
    {
        \Storage::fake('local');
        $branch = $this->branchFactory->create();

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.branches.update', $branch->id), $branch->toArray() + [
                'branch-gallery' => [UploadedFile::fake()->image('file.png')],
            ]
        )->assertStatus(200);
        $this->assertNotNull($response->getData(true)['data']['media']);
    }

    /** @test */
    public function it_shouldnt_let_user_update_branch_if_doesnt_exist()
    {
        $this->put(
            route('api.branches.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_branch_if_doesnt_have_permission()
    {
        $branch = $this->branchFactory->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.branches.update', $branch->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_branch_if_latitude_already_exists()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        config(['app.locale' => 'ar']);
        $anotherBranch = $this->branchFactory->create([
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.branches.update', $anotherBranch->id), ['latitude' => $branch->latitude] + $anotherBranch->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['latitude']);
    }

    /** @test */
    public function it_shouldnt_update_branch_if_longitude_already_exists()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        config(['app.locale' => 'ar']);
        $anotherBranch = $this->branchFactory->create([
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.branches.update', $anotherBranch->id), ['longitude' => $branch->longitude] + $anotherBranch->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['longitude']);
    }

    /** @test */
    public function it_shouldnt_update_branch_if_name_of_branch_already_existing()
    {
        $branch = $this->branchFactory->create();
        $anotherBranch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'PUT',
            route('api.branches.update', $branch), [
                'name' => $anotherBranch->name,
            ]
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_update_branch_if_unauthenticated()
    {
        $branch = $this->branchFactory->create();
        $this->put(
            route('api.branches.update', $branch->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->branchFactory = Branch::factory();
    }
}

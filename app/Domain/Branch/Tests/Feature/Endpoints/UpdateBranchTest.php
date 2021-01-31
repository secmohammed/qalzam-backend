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
    public function it_should_let_user_update_branch_with_existing_parent()
    {
        $branch = $this->branchFactory->withStatus('active')->create();
        $parentBranch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.branches.update', $branch->id) . '?include=parent', [
                'name' => 'hello',
                'name_ar' => $name = 'الاسم بالعربي',
                'type' => 'product',
                'parent_id' => $parentBranch->id,
            ]
        )->assertStatus(200);
        $this->assertDatabaseHas('branches', [
            'parent_id' => $parentBranch->id,
            'id' => $branch->id,
        ]);

    }

    /** @test */
    public function it_should_let_user_update_branch_with_product()
    {
        $branch = $this->branchFactory->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.branches.update', [
                'branch' => $branch->id,
            ]), [
                'name' => 'hello',
                'name_ar' => $name = 'الاسم بالعربي',
                'type' => 'product',
            ]
        )->assertStatus(200);

    }

    /** @test */
    public function it_should_update_branch_with_icon()
    {
        \Storage::fake('local');
        $branch = $this->branchFactory->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.branches.update', $branch->id), [
                'name' => 'hello',
                'type' => 'product',
                'name_ar' => $name = 'الاسم بالعربي',
                'icon' => UploadedFile::fake()->image('file.png'),
            ]
        )->assertStatus(200);
        $this->assertNotNull($response->getData(true)['data']['icon']);
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
        $branch = $this->branchFactory->withStatus('active')->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.branches.update', $branch->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_let_user_update_branch_with_parent_if_parent_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $branch = $this->branchFactory->withStatus('active')->create();

        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'PUT',
            route('api.branches.update', $branch->id), [
                'name' => 'hello',
                'type' => 'product',
                'parent_id' => 100,
            ]
        )->assertStatus(422);

    }

    /** @test */
    public function it_shouldnt_update_branch_if_name_of_branch_already_existing()
    {
        $branch = $this->branchFactory->withStatus('active')->create();
        $anotherBranch = $this->branchFactory->withStatus('active')->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.branches.update', $branch), [
                'name' => $anotherBranch->name,
            ]
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_update_branch_if_unauthenticated()
    {
        $branch = $this->branchFactory->withStatus('active')->create();
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

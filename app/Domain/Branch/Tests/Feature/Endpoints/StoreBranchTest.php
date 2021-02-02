<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;

class StoreBranchTest extends TestCase
{
    /** @test */
    public function it_should_create_branch_with_gallery()
    {
        \Storage::fake('local');

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        config(['app.locale' => 'ar']);
        $user->roles()->attach(Role::first());
        $branch = $this->branchFactory->make();
        $response = $this->jsonAs($user, 'POST',
            route('api.branches.store'), $branch->toArray() + [
                'branch-gallery' => [UploadedFile::fake()->image('file.png')],
            ]
        );
        $this->assertNotNull($response->getData(true)['data']['media']);
    }

    /** @test */
    public function it_should_let_user_create_branch_with_product()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST',
            route('api.branches.store'), [
                'name' => 'hello',
                'name_ar' => $name = 'الاسم بالعربي',
                'type' => 'product',
            ]
        )->assertStatus(201);
    }

    /** @test */
    public function it_should_store_branch_if_name_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST',
            route('api.branches.store'), [
                'name' => 'hello',
                'type' => 'product',
                'name_ar' => 'الاسم بالعربي',
            ]
        )->assertStatus(201);
    }

    /** @test */
    public function it_shouldnt_create_branch_if_latitude_already_exists()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        config(['app.locale' => 'ar']);
        $anotherBranch = $this->branchFactory->make([
            'latitude' => $branch->latitude,
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST',
            route('api.branches.store'), $anotherBranch->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['latitude']);
    }

    /** @test */
    public function it_shouldnt_create_branch_if_longitude_already_exists()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        config(['app.locale' => 'ar']);
        $anotherBranch = $this->branchFactory->make([
            'longitude' => $branch->longitude,
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST',
            route('api.branches.store'), $anotherBranch->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['longitude']);
    }

    /** @test */
    public function it_shouldnt_let_user_create_branch_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.branches.store'), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_store_branch_if_name_of_branch_already_existing()
    {
        $branch = $this->branchFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'POST',
            route('api.branches.store'), [
                'name' => $branch->name,
            ]
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_store_branch_if_unauthenticated()
    {
        $this->post(
            route('api.branches.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->branchFactory = Branch::factory();
    }
}

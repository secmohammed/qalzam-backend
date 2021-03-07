<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\BranchShift;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Branch\Entities\BranchShift;

class IndexBranchShiftsTest extends TestCase
{
    /** @test */
    public function it_should_fetch_branch_shifts_with_branch_when_available()
    {
        $this->branchShiftFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branch_shifts.index') . '?include=branch'
        );
        $this->assertTrue(array_key_exists('branch', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branch_shifts_with_user_when_available()
    {
        $this->branchShiftFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branch_shifts.index') . '?include=user'
        );
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_branch_shifts_by_branch_id()
    {
        $this->branchShiftFactory->count(5)->create([
            'status' => 'active',
        ]);
        $shift = $this->branchShiftFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branch_shifts.index'), 'filter[branch.id]', $shift->branch_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($shift->branch_id, $response->getData(true)['data'][0]['branch_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branch_shifts_by_day()
    {
        $this->branchShiftFactory->create([
            'status' => 'active',
            'day' => 'satruday',
        ]);
        $this->branchShiftFactory->create([
            'status' => 'active',
            'day' => 'sunday',
        ]);
        $this->branchShiftFactory->create([
            'status' => 'active',
            'day' => 'monday',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branch_shifts.index'), 'filter[day]', 'monday')
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_branch_shifts_by_user_id()
    {
        $this->branchShiftFactory->count(5)->create([
            'status' => 'active',

        ]);
        $shift = $this->branchShiftFactory->create([
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.branch_shifts.index'), 'filter[user.id]', $shift->user_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($shift->user_id, $response->getData(true)['data'][0]['user_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->branchShiftFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->branchShiftFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->branchShiftFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branch_shifts.index') . '?sort=created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    /** @test */
    public function it_should_sort_by_created_at_descending()
    {
        $this->branchShiftFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->branchShiftFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->branchShiftFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.branch_shifts.index') . '?sort=-created_at'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertEquals(
            Carbon::parse($firstCreatedAt)->diffForHumans(),
            $response->getData(true)['data'][0]['created_at_human']
        );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->branchShiftFactory = BranchShift::factory();
        $this->userFactory = User::factory();

        $this->user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $this->user->roles()->attach(Role::first());
    }
}

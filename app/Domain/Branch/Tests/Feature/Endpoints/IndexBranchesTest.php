<?php
namespace App\Domain\Branch\Tests\Feature\Endpoints;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\Branch\Entities\Branch;

class IndexCategoriesTest extends TestCase
{
    /** @test */
    public function it_should_fetch_branches_with_children_when_available()
    {
        $this->branchFactory->withChildren()->withStatus('active')->create();
        $response = $this->get(
            route('api.branches.index') . '?include=children'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('children', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_branches_with_parent_when_available()
    {
        $this->branchFactory->withParent()->withStatus('active')->create();
        $response = $this->get(
            route('api.branches.index') . '?include=parent'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('parent', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_branches_by_name()
    {
        $this->branchFactory->count(5)->create();
        $this->branchFactory->create([
            'name' => $name = 'hello',
            'status' => 'active',
        ]);
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[name]', $name)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($name, $response->getData(true)['data'][0]['name']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_branches_by_type()
    {
        $this->branchFactory->withPostType()->withStatus('active')->count(3)->create();
        $this->branchFactory->withStatus('inactive')->create();
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.branches.index'), 'filter[type]', 'post')
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /**  @test */
    public function it_should_list_all_of_active_branches_paginated_by_default()
    {
        $this->branchFactory->count(5)->withStatus('active')->create();
        $this->branchFactory->withStatus('inactive')->create();
        $response = $this->get(
            route('api.branches.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    // /** @test */
    // public function it_should_return_branches_with_products_included()
    // {
    //     $branches = $this->branchFactory->withProduct(3)->withSpeciality()->withStatus('active')->create();
    //     $response = $this->get(
    //         route('api.branches.index') . '?include=doctors'
    //     )->assertJsonStructure([
    //         'data',
    //     ]);
    //     $this->assertTrue(array_key_exists('doctors', $response->getData(true)['data'][0]));
    //     $this->assertCount(3, $response->getData(true)['data'][0]['doctors']);
    // }

    // /** @test */
    // public function it_should_return_branches_with_posts_included()
    // {
    //     $branches = $this->branchFactory->withPost(3)->withStatus('active')->create();
    //     $response = $this->get(
    //         route('api.branches.index') . '?include=posts'
    //     )->assertJsonStructure([
    //         'data',
    //     ]);
    //     $this->assertTrue(array_key_exists('posts', $response->getData(true)['data'][0]));
    //     $this->assertCount(3, $response->getData(true)['data'][0]['posts']);
    // }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->branchFactory->withStatus('active')->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->branchFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->branchFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->get(
            route('api.branches.index') . '?sort=created_at'
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
        $this->branchFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->branchFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->branchFactory->withStatus('active')->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->get(
            route('api.branches.index') . '?sort=-created_at'
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
        $this->branchFactory = Branch::factory();
    }
}

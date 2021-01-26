<?php
namespace App\Domain\Category\Tests\Feature\Endpoints;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\Category\Entities\Category;

class IndexCategoriesTest extends TestCase
{
    /** @test */
    public function it_should_fetch_categories_with_children_when_available()
    {
        $this->categoryFactory->withChildren()->withStatus('active')->create();
        $response = $this->get(
            route('api.categories.index') . '?include=children'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('children', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_categories_with_parent_when_available()
    {
        $this->categoryFactory->withParent()->withStatus('active')->create();
        $response = $this->get(
            route('api.categories.index') . '?include=parent'
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertTrue(array_key_exists('parent', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_categories_by_name()
    {
        $this->categoryFactory->count(5)->create();
        $this->categoryFactory->create([
            'name' => $name = 'hello',
            'status' => 'active',
        ]);
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.categories.index'), 'filter[name]', $name)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($name, $response->getData(true)['data'][0]['name']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_categories_by_type()
    {
        $this->categoryFactory->withPostType()->withStatus('active')->count(3)->create();
        $this->categoryFactory->withStatus('inactive')->create();
        $response = $this->get(
            sprintf('%s?%s=%s', route('api.categories.index'), 'filter[type]', 'post')
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(3, $response->getData(true)['data']);
    }

    /**  @test */
    public function it_should_list_all_of_active_categories_paginated_by_default()
    {
        $this->categoryFactory->count(5)->withStatus('active')->create();
        $this->categoryFactory->withStatus('inactive')->create();
        $response = $this->get(
            route('api.categories.index')
        )->assertJsonStructure([
            'data',
            'links',
            'meta',
        ])->getData(true);
        $this->assertCount(5, $response['data']);
    }

    // /** @test */
    // public function it_should_return_categories_with_products_included()
    // {
    //     $categories = $this->categoryFactory->withProduct(3)->withSpeciality()->withStatus('active')->create();
    //     $response = $this->get(
    //         route('api.categories.index') . '?include=doctors'
    //     )->assertJsonStructure([
    //         'data',
    //     ]);
    //     $this->assertTrue(array_key_exists('doctors', $response->getData(true)['data'][0]));
    //     $this->assertCount(3, $response->getData(true)['data'][0]['doctors']);
    // }

    // /** @test */
    // public function it_should_return_categories_with_posts_included()
    // {
    //     $categories = $this->categoryFactory->withPost(3)->withStatus('active')->create();
    //     $response = $this->get(
    //         route('api.categories.index') . '?include=posts'
    //     )->assertJsonStructure([
    //         'data',
    //     ]);
    //     $this->assertTrue(array_key_exists('posts', $response->getData(true)['data'][0]));
    //     $this->assertCount(3, $response->getData(true)['data'][0]['posts']);
    // }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->categoryFactory->withStatus('active')->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->categoryFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->categoryFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->get(
            route('api.categories.index') . '?sort=created_at'
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
        $this->categoryFactory->withStatus('active')->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);
        $this->categoryFactory->withStatus('active')->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);
        $this->categoryFactory->withStatus('active')->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
        ]);
        $response = $this->get(
            route('api.categories.index') . '?sort=-created_at'
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
        $this->categoryFactory = Category::factory();
    }
}

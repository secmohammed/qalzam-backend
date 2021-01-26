<?php

namespace App\Domain\Category\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\Category\Entities\Category;

class ShowCategoryTest extends TestCase
{
    /** @test */
    public function it_should_fetch_category_by_id()
    {
        $category = $this->categoryFactory->withStatus('active')->create();
        $this->get(
            '/api/categories/' . $category->id
        )->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'type',
                'created_at_human',
            ],
        ]);
    }

    /** @test */
    public function it_shouldnt_fetch_category_by_id_if_not_currently_active()
    {
        $category = $this->categoryFactory->withStatus('inactive')->create();
        $this->get(
            route('api.categories.show', $category->id)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_fetch_category_by_id_if_not_found()
    {
        $this->get(
            route('api.categories.show', 100)
        )->assertStatus(404);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryFactory = Category::factory();
    }
}

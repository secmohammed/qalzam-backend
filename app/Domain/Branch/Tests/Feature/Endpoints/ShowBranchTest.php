<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints;

use Tests\TestCase;
use App\Domain\Branch\Entities\Branch;

class ShowBranchTest extends TestCase
{
    /** @test */
    public function it_should_fetch_category_by_id()
    {
        $category = $this->branchFactory->withStatus('active')->create();
        $this->get(
            '/api/branches/' . $category->id
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
        $category = $this->branchFactory->withStatus('inactive')->create();
        $this->get(
            route('api.branches.show', $category->id)
        )->assertStatus(404);
    }

    /** @test */
    public function it_shouldnt_fetch_category_by_id_if_not_found()
    {
        $this->get(
            route('api.branches.show', 100)
        )->assertStatus(404);

    }

    public function setUp(): void
    {
        parent::setUp();
        $this->branchFactory = Branch::factory();
    }
}

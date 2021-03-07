<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Template;

use Carbon\Carbon;
use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Template;

class IndexTemplatesTest extends TestCase
{
    /** @test */
    public function it_should_fetch_templates_with_products_when_available()
    {
        $template = $this->templateFactory->withProducts()->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.templates.index') . '?include=products'
        );
        $this->assertTrue(array_key_exists('products', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_fetch_templates_with_user_when_available()
    {
        $this->templateFactory->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.templates.index') . '?include=user'
        );
        $this->assertTrue(array_key_exists('user', $response->getData(true)['data'][0]));

    }

    /** @test */
    public function it_should_filter_templates_by_name()
    {
        $templates = $this->templateFactory->count(3)->create([
            'status' => 'active',
        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.templates.index'), 'filter[name]', $templates->first()->name)
        )->assertJsonStructure([
            'data',
        ]);
        $this->assertCount(1, $response->getData(true)['data']);
    }

    /** @test */
    public function it_should_filter_templates_by_products_id()
    {
        $this->templateFactory->count(5)->create([
            'status' => 'active',

        ]);
        $template = $this->templateFactory->withProducts()->create([
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.templates.index'), 'filter[products.id]', $template->products->first()->id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_filter_templates_by_user_id()
    {
        $this->templateFactory->count(5)->create([
            'status' => 'active',

        ]);
        $template = $this->templateFactory->create([
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            sprintf('%s?%s=%s', route('api.templates.index'), 'filter[user.id]', $template->user_id)
        )->assertJsonStructure([
            'data',
            'links',
            'meta',

        ]);
        $this->assertEquals($template->user_id, $response->getData(true)['data'][0]['user_id']);
        $this->assertEquals(1, count($response->getData(true)['data']));
    }

    /** @test */
    public function it_should_sort_by_created_at_ascending()
    {
        $this->templateFactory->create([
            'created_at' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->templateFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->templateFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.templates.index') . '?sort=created_at'
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
        $this->templateFactory->create([
            'created_at' => $firstCreatedAt = now()->subDays(1)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->templateFactory->create([
            'created_at' => now()->subDays(2)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $this->templateFactory->create([
            'created_at' => now()->subDays(3)->format('Y-m-d H:i:s'),
            'status' => 'active',

        ]);
        $response = $this->jsonAs(
            $this->user,
            'GET',
            route('api.templates.index') . '?sort=-created_at'
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
        $this->templateFactory = Template::factory();
        $this->userFactory = User::factory();

        $this->user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $this->user->roles()->attach(Role::first());
    }
}

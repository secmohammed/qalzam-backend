<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Template;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Template;

class ShowTemplateTest extends TestCase
{
    /** @test */
    public function it_should_fetch_template_by_id_if_authenticated_and_has_permissions()
    {
        $template = $this->templateFactory->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs(
            $user,
            'GET',
            route('api.templates.show', $template->id)
        )->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'user_id',
                'created_at_human',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_fetch_brnach_if_authenticated_but_doesnt_have_permissions()
    {
        $template = $this->templateFactory->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $this->jsonAs(
            $user,
            'GET',
            route('api.templates.show', $template->id)
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_fetch_template_by_id_if_not_found()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs(
            $user,
            'GET',
            route('api.templates.show', 100)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_fetch_template_if_not_authenticated()
    {
        $template = $this->templateFactory->create([
            'status' => 'active',
        ]);
        $this->get(
            route('api.templates.show', $template->id)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->templateFactory = Template::factory();
        $this->userFactory = User::factory();
    }
}

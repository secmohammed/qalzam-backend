<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Template;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Template;

class StoreTemplateTest extends TestCase
{
    /** @test */
    public function it_should_let_user_create_template()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $template = $this->templateFactory->make([
        ]);

        $response = $this->jsonAs($user, 'POST',
            route('api.templates.store'), $template->toArray() + [

            ]
        )->assertStatus(201);
    }

    /** @test */
    public function it_shouldnt_let_user_create_template_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.templates.store'), [
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_store_template_if_name_of_template_already_existing()
    {
        $template = $this->templateFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $template = $this->templateFactory->make([
            'name' => $template->name,
        ]);
        $this->jsonAs($user, 'POST',
            route('api.templates.store'), $template->toArray() + [

            ]
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_store_template_if_unauthenticated()
    {
        $this->post(
            route('api.templates.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->templateFactory = Template::factory();
    }
}

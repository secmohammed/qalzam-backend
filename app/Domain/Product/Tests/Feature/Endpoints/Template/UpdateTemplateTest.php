<?php

namespace App\Domain\Product\Tests\Feature\Endpoints\Template;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Template;

class UpdateTemplateTest extends TestCase
{
    /** @test */
    public function it_should_update_template()
    {

        $template = $this->templateFactory->create([
            'status' => 'active',
        ]);

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.templates.update', $template->id), $template->toArray() + [

            ]
        )->assertStatus(200);

    }

    /** @test */
    public function it_shouldnt_let_user_update_template_if_doesnt_exist()
    {
        $this->put(
            route('api.templates.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_template_if_doesnt_have_permission()
    {
        $template = $this->templateFactory->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.templates.update', $template->id), [
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_template_if_name_already_exists()
    {
        $template = $this->templateFactory->create([
            'status' => 'active',
        ]);
        $user = $this->userFactory->create();
        $anotherTemplate = $this->templateFactory->create([
            'status' => 'active',
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.templates.update', $anotherTemplate->id), ['name' => $template->name] + $anotherTemplate->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_update_template_if_unauthenticated()
    {
        $template = $this->templateFactory->create([
            'status' => 'active',
        ]);
        $this->put(
            route('api.templates.update', $template->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->templateFactory = Template::factory();
    }
}

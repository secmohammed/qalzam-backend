<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Template;

use Tests\TestCase;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Template;

class DestroyTemplateTest extends TestCase
{
    /** @test */
    public function it_should_delete_template_when_having_permission_and_existing()
    {
        $user = $this->userFactory->create();
        $template = $this->templateFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.templates.destroy', $template->id)
        )->assertStatus(200);

    }

    /** @test */
    public function it_should_delete_template_when_user_is_deleted()
    {
        $user = $this->userFactory->create();
        $template = $this->templateFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        User::whereId($template->user_id)->delete();
        $this->assertDatabaseMissing('templates', [
            'id' => $template->id,
        ]);
    }

    /** @test */
    public function it_shouldnt_destroy_template_if_doesnt_exist()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $this->jsonAs($user, 'DELETE',
            route('api.templates.destroy', 1)
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_destroy_template_if_not_having_permission_of_deleting_template()
    {
        $template = $this->templateFactory->create();
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'DELETE',
            route('api.templates.destroy', 1)
        )->assertStatus(401);
    }

    /** @test */
    public function it_shouldnt_destroy_template_if_unauthenticated()
    {
        $this->delete(
            route('api.templates.destroy', 1)
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->templateFactory = Template::factory();
    }
}

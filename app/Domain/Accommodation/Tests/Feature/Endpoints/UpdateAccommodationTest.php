<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use Joovlly\Authorizable\Models\Role;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Accommodation\Entities\Accommodation;

class UpdateAccommodationTest extends TestCase
{
    /** @test */
    public function it_should_update_accommodation_with_gallery()
    {
        \Storage::fake('local');
        $accommodation = $this->accommodationFactory->create();

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.accommodations.update', $accommodation->id), $accommodation->toArray() + [
                'accommodation-gallery' => [UploadedFile::fake()->image('file.png')],
            ]
        );
        $this->assertNotNull($response->getData(true)['data']['media']);
    }

    /** @test */
    public function it_shouldnt_let_user_update_accommodation_if_doesnt_exist()
    {
        $this->put(
            route('api.accommodations.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_accommodation_if_doesnt_have_permission()
    {
        $accommodation = $this->accommodationFactory->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.accommodations.update', $accommodation->id), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_accommodation_if_code_already_exists()
    {
        $accommodation = $this->accommodationFactory->create();
        $user = $this->userFactory->create();
        config(['app.locale' => 'ar']);
        $anotherAccommodation = $this->accommodationFactory->create([
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.accommodations.update', $anotherAccommodation->id), ['code' => $accommodation->code] + $anotherAccommodation->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['code']);
    }

    /** @test */
    public function it_shouldnt_update_accommodation_if_name_already_exists()
    {
        $accommodation = $this->accommodationFactory->create();
        $user = $this->userFactory->create();
        config(['app.locale' => 'ar']);
        $anotherAccommodation = $this->accommodationFactory->create([
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.accommodations.update', $anotherAccommodation->id), ['name' => $accommodation->name] + $anotherAccommodation->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_update_accommodation_if_unauthenticated()
    {
        $accommodation = $this->accommodationFactory->create();
        $this->put(
            route('api.accommodations.update', $accommodation->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->accommodationFactory = Accommodation::factory();
    }
}

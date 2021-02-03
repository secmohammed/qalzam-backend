<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Accommodation\Entities\Accommodation;

class StoreAccommodationTest extends TestCase
{
    /** @test */
    public function it_should_create_accommodation_with_gallery()
    {
        \Storage::fake('local');

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationFactory->make();
        $response = $this->jsonAs($user, 'POST',
            route('api.accommodations.store'), $accommodation->toArray() + [
                'accommodation-gallery' => [UploadedFile::fake()->image('file.png')],
            ]
        );
        $this->assertNotNull($response->getData(true)['data']['media']);
    }

    /** @test */
    public function it_shouldnt_create_accommodation_if_code_already_exists()
    {
        $accommodation = $this->accommodationFactory->create();
        $user = $this->userFactory->create();
        $anotherAccommodation = $this->accommodationFactory->make([
            'code' => $accommodation->code,
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST',
            route('api.accommodations.store'), $anotherAccommodation->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['code']);
    }

    /** @test */
    public function it_shouldnt_create_accommodation_if_name_already_exists()
    {
        $accommodation = $this->accommodationFactory->create();
        $user = $this->userFactory->create();
        $anotherAccommodation = $this->accommodationFactory->make([
            'name' => $accommodation->name,
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'POST',
            route('api.accommodations.store'), $anotherAccommodation->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_let_user_create_accommodation_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.accommodations.store'), [
                'name' => 'hello',
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_store_accommodation_if_name_of_accommodation_already_existing()
    {
        $accommodation = $this->accommodationFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());

        $this->jsonAs($user, 'POST',
            route('api.accommodations.store'), [
                'name' => $accommodation->name,
            ]
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_store_accommodation_if_unauthenticated()
    {
        $this->post(
            route('api.accommodations.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->accommodationFactory = Accommodation::factory();
    }
}

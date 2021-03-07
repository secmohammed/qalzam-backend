<?php

namespace App\Domain\Accommodation\Tests\Feature\Endpoints\Accommodation;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use App\Domain\Product\Entities\Template;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Accommodation\Entities\Accommodation;

class StoreAccommodationTest extends TestCase
{
    /** @test */
    public function it_should_create_accommodation_with_contract_id_if_accommodation_type_is_room()
    {
        \Storage::fake('local');

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $contract = Contract::factory()->create();
        $accommodation = $this->accommodationFactory->make([
            'type' => 'room',
            'contract_id' => $contract->id,
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.accommodations.store'), $accommodation->toArray() + [
                'accommodation-gallery' => [UploadedFile::fake()->image('file.png')],
            ]
        );
        $this->assertEquals($contract->id, $response->getData(true)['data']['contract_id']);

    }

    /** @test */
    public function it_should_create_accommodation_with_gallery()
    {
        \Storage::fake('local');

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationFactory->make([
            'type' => 'table',
            'contract_id' => null,
        ]);
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
            'type' => 'table',

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

            'type' => 'table',
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
    public function it_shouldnt_pass_validation_if_accommodation_if_type_is_room_and_contract_id_isnt_passed()
    {
        \Storage::fake('local');

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $accommodation = $this->accommodationFactory->make([
            'type' => 'room',
            'contract_id' => 100,
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.accommodations.store'), $accommodation->toArray() + [
                'accommodation-gallery' => [UploadedFile::fake()->image('file.png')],
            ]
        )->assertJsonValidationErrors(['contract_id']);

    }

    /** @test */
    public function it_shouldnt_store_accommodaiton_if_contract_id_exists_but_isnt_attached_to_template_that_has_products()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $template = Template::factory()->create();
        $contract = Contract::factory()->create([
            'template_id' => $template->id,
        ]);
        $accommodation = $this->accommodationFactory->make([
            'type' => 'room',
            'contract_id' => $contract->id,
        ]);
        $response = $this->jsonAs($user, 'POST',
            route('api.accommodations.store'), $accommodation->toArray() + [
                'accommodation-gallery' => [UploadedFile::fake()->image('file.png')],
            ]
        )->assertJsonValidationErrors(['contract_id']);
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

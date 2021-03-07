<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Album;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Album;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;

class StoreAlbumTest extends TestCase
{
    /** @test */
    public function it_should_let_user_create_album_with_gallery()
    {
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $album = $this->albumFactory->make([
        ]);

        $response = $this->jsonAs($user, 'POST',
            route('api.albums.store'), $album->toArray() + [
                'album-gallery' => [UploadedFile::fake()->image('file.png')],

            ]
        )->assertStatus(201);
    }

    /** @test */
    public function it_shouldnt_let_user_create_branch_if_doesnt_have_permission()
    {
        $user = $this->userFactory->create();
        $this->jsonAs($user, 'POST',
            route('api.albums.store'), [
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_store_album_if_name_of_album_already_existing()
    {
        $album = $this->albumFactory->create();
        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $album = $this->albumFactory->make([
            'name' => $album->name,
        ]);
        $this->jsonAs($user, 'POST',
            route('api.albums.store'), $album->toArray() + [
                'album-gallery' => [UploadedFile::fake()->image('file.png')],

            ]
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_store_branch_if_unauthenticated()
    {
        $this->post(
            route('api.albums.store'), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->albumFactory = Album::factory();
    }
}

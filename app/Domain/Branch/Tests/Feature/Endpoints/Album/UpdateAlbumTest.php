<?php

namespace App\Domain\Branch\Tests\Feature\Endpoints\Album;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Domain\User\Entities\User;
use App\Domain\Branch\Entities\Album;
use Joovlly\Authorizable\Models\Role;
use App\Domain\Branch\Entities\Branch;
use Database\Seeders\RolesTableSeeder;

class UpdateAlbumTest extends TestCase
{
    /** @test */
    public function it_should_update_album()
    {

        $album = $this->albumFactory->create([
            'status' => 'active',
        ]);

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.albums.update', $album->id), $album->toArray() + [

            ]
        )->assertStatus(200);

    }

    /** @test */
    public function it_should_update_album_with_gallery()
    {
        \Storage::fake('local');

        $album = $this->albumFactory->create([
            'status' => 'active',
        ]);

        $user = $this->userFactory->create();
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.albums.update', $album->id), $album->toArray() + [
                'album-gallery' => [UploadedFile::fake()->image('file.png')],

            ]
        )->assertStatus(200);
        $this->assertNotNull($response->getData(true)['data']['media']);

    }

    /** @test */
    public function it_shouldnt_let_user_update_album_if_doesnt_exist()
    {
        $this->put(
            route('api.albums.update', 1), []
        )->assertStatus(404);

    }

    /** @test */
    public function it_shouldnt_let_user_update_album_if_doesnt_have_permission()
    {
        $album = $this->albumFactory->create();

        $user = $this->userFactory->create();
        $this->jsonAs($user, 'PUT',
            route('api.albums.update', $album->id), [
            ]
        )->assertStatus(401);

    }

    /** @test */
    public function it_shouldnt_update_album_if_name_already_exists()
    {
        $album = $this->albumFactory->create();
        $user = $this->userFactory->create();
        config(['app.locale' => 'ar']);
        $anotherAlbum = $this->albumFactory->create([
        ]);
        $this->seed(RolesTableSeeder::class);
        $user->roles()->attach(Role::first());
        $response = $this->jsonAs($user, 'PUT',
            route('api.albums.update', $anotherAlbum->id), ['name' => $album->name] + $anotherAlbum->toArray()
        )->assertStatus(422)->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_shouldnt_update_album_if_unauthenticated()
    {
        $album = $this->albumFactory->create();
        $this->put(
            route('api.albums.update', $album->id), []
        )->assertStatus(401);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userFactory = User::factory();
        $this->albumFactory = Album::factory();
    }
}

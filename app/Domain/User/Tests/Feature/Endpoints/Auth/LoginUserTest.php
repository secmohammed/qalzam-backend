<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use Tests\TestCase;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;

class LoginUserTest extends TestCase
{
    /** @test */
    public function it_should_login_user_if_data_is_correct()
    {
        $user = User::factory()->create([
            'email' => 'mohammedosama@ieee.org',
        ]);
        $response = $this->post(
            '/api/auth/login',
            [
                'email' => $user->email,
                'password' => 'password',
                'device_token' => 'abc',
                'device' => 'ios',
            ]
        )->assertJsonStructure([
            'data', 'meta' => [
                'token',
            ],
        ]);
    }

    /** @test */
    public function it_should_login_user_with_children_relation_if_data_is_correct()
    {
        $user = User::factory()->create([
            'email' => 'mohammedosama@ieee.org',
        ]);
        $response = $this->post(
            '/api/auth/login?include=children',
            [
                'email' => $user->email,
                'password' => 'password',
                'device_token' => 'abc',
                'device' => 'ios',
            ]
        )->assertJsonStructure([
            'data' => [
                'children',
            ], 'meta' => [
                'token',
            ],
        ]);

    }

    /** @test */
    public function it_should_login_user_with_roles_relation_if_data_is_correct()
    {
        $user = User::factory()->create([
            'email' => 'mohammedosama@ieee.org',
        ]);
        $user->roles()->attach(Role::first());
        $user->roles()->attach(Role::whereSlug('user')->first());
        $response = $this->post(
            '/api/auth/login?include=roles',
            [
                'email' => $user->email,
                'password' => 'password',
                'device_token' => 'abc',
                'device' => 'ios',
            ]
        )->assertJsonStructure([
            'data' => [
                'permissions',
            ], 'meta' => [
                'token',
            ],
        ]);

    }

    /** @test */
    public function it_shouldnt_let_user_login_if_passed_credentials_are_invalid()
    {
        $user = User::factory()->create([
            'email' => 'mohammedosama@ieee.org',
        ]);
        $response = $this->post(
            '/api/auth/login',
            [
                'email' => 'secret@gmail.com',
                'password' => 'password',
            ]
        )->assertStatus(422);
    }

    /** @test */
    public function it_shouldnt_let_user_login_if_validation_didnt_pass()
    {
        $this->post(
            '/api/auth/login',
            [
                'email' => 'someone',
                'password' => 'secret',
            ]
        )->assertStatus(422);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('RolesTableSeeder');
    }
}

<?php

namespace App\Domain\User\Tests\Feature\Endpoints\Auth;

use Tests\TestCase;
use App\Domain\User\Entities\User;

class RegisterUserTest extends TestCase
{
    /** @test */
    public function it_registers_user_with_correct_data()
    {
        $user = User::factory()->make([
            'username' => 'mohammed',
            'mobile' => '966505552279',
            'email' => 'hello@gmail.com',
        ]);
        $response = $this->post(
            '/api/auth/register',
            array_merge($user->toArray(), [
                'password' => 'secret123!@#',
                'password_confirmation' => 'secret123!@#',
                'mobile' => '01067123849',

            ])
        )->assertStatus(201);

    }

    /** @test */
    public function it_shouldnt_let_user_register_if_email_exists()
    {
        $user = User::factory()->create([
            'mobile' => '966505552279',
        ]);
        $this->post(
            '/api/auth/register',
            array_merge($user->toArray(), [
                'password' => 'secret123!@#',
                'password_confirmation' => 'secret123!@#',
                'mobile' => '01067123849',

            ])

        )->assertStatus(422);
    }

    /** @test */
    public function it_shouldnt_let_user_register_if_mobile_exists()
    {
        $user = User::factory()->create([
            'mobile' => '01067123849',
        ]);
        $this->post(
            '/api/auth/register',
            array_merge($user->toArray(), [
                'mobile' => '01067123849',
                'email' => 'mohammedosama@ieee.org',
                'password' => 'secret123!@#',
                'password_confirmation' => 'secret123!@#',
            ])

        )->assertStatus(422);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('RolesTableSeeder');
    }
}

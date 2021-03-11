<?php

namespace App\Domain\User\Database\Seeds;

use App\Domain\User\Entities\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()->count(100)->create();
        foreach ($users as $user) {
            $user->first()->update([
                'mobile' => '01150480509',
                'email' => 'mohamed.selim@joovlly.com',
                'name' => 'Mohamed Selim',
            ]);
            $user->first()->roles()->sync(1);
            $user->addMedia(public_path('user.jpg'))
                ->preservingOriginal()->toMediaCollection('image');
        }

    }
}

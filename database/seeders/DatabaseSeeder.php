<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);

        \App\Domain\Discount\Entities\Discount::factory()->withUsersUsing(3)->create();
        \App\Domain\Discount\Entities\Discount::factory()->doesntExpire()->create();
        \App\Domain\Discount\Entities\Discount::factory()->alreadyExpired()->create();
        \App\Domain\Location\Entities\Location::factory()->withChildren(2)->count(10)->create();
        \App\Domain\Order\Entities\Order::factory()->withProducts(3)->count(10)->create();
        \App\Domain\Reservation\Entities\Reservation::factory()->count(10)->create();
        \App\Domain\Post\Entities\Post::factory()->count(100)->create();
        $user = \App\Domain\User\Entities\User::first();
        $user->update([
            'mobile' => '01150480509',
            'email' => 'mohamed.selim@joovlly.com',
            'name' => 'Mohamed Selim',
        ]);
        $user->roles()->attach(1);}
}

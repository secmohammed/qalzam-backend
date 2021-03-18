<?php

namespace Database\Seeders;

use App\Domain\Accommodation\Entities\Accommodation;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Branch\Entities\Album;
use App\Domain\Branch\Entities\BranchShift;
use App\Domain\Category\Entities\Category;
use App\Domain\Product\Entities\Template;
use App\Domain\User\Entities\Address;
use App\Domain\User\Entities\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Database\Seeder;

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
        \App\Domain\Post\Entities\Post::factory()->count(30)->create();
        Album::factory()->count(30)->create();
        Contract::factory()->count(30)->create();
        BranchShift::factory()->count(30)->create();
        Category::factory()->count(20)->create();
        Template::factory()->withProducts([], 10)->count(30)->create();
        Accommodation::factory()->count(10)->create();

        $user = \App\Domain\User\Entities\User::first();
        $user2 = User::factory(["email" => "m@m.com", "password" => bcrypt("12345678")])->create();
        Address::factory(['user_id' => $user2->id])->count(10)->create();
        $user->update([
            'mobile' => '01150480509',
            'email' => 'mohamed.selim@joovlly.com',
            'name' => 'Mohamed Selim',
        ]);

        $user3 = User::factory(["email" => "deliv@m.com", "name" => "delivary", "password" => bcrypt("12345678")])->create();
        $user3 = User::factory(["email" => "call.cen@m.com", "name" => "call_center", "password" => bcrypt("12345678")])->create();
        $user4 = User::factory(["email" => "branc_manager@m.com", "name" => "branc manager1", "password" => bcrypt("12345678")])->create();
        $user5 = User::factory(["email" => "branc_manager2@m.com", "name" => "branc manager2", "password" => bcrypt("12345678")])->create();

        $user->roles()->attach(1);
        $user2->roles()->attach(1);
        $user3->roles()->attach(2);
        $user3->roles()->attach(3);
        $user4->roles()->attach(4);
        $user5->roles()->attach(4);

    }
}

<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Joovlly\Authorizable\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'permissions' => [
                'store-discount' => true,
                'create-discount' => true,
                'edit-discount' => true,
                'show-discount' => true,
                'destroy-discount' => true,
                'index-discount' => true,
                'update-discount' => true,

                'store-ingredient' => true,
                'create-ingredient' => true,
                'edit-ingredient' => true,
                'show-ingredient' => true,
                'destroy-ingredient' => true,
                'index-ingredient' => true,
                'update-ingredient' => true,

                'store-stock' => true,
                'create-stock' => true,
                'edit-stock' => true,
                'show-stock' => true,
                'destroy-stock' => true,
                'index-stock' => true,
                'update-stock' => true,

                'store-address' => true,
                'show-address' => true,
                'destroy-address' => true,
                'index-address' => true,
                'update-address' => true,
                'edit-address' => true,
                'create-address' => true,

                'store-user_order' => true,
                'show-user_order' => true,
                'edit-user_order' => true,
                'create-user_order' => true,
                'index-user_order' => true,
                'update-user_order' => true,
                'destroy-user_order' => true,

                'store-order' => true,
                'create-order' => true,
                'edit-order' => true,
                'show-order' => true,
                'destroy-order' => true,
                'index-order' => true,
                'update-order' => true,

                'store-post' => true,
                'index-post' => true,
                'create-post' => true,
                'edit-post' => true,
                'show-post' => true,
                'update-post' => true,
                'destroy-post' => true,
                'approve-post' => true,

                'store-location' => true,
                'create-location' => true,
                'edit-location' => true,
                'index-location' => true,
                'show-location' => true,
                'update-location' => true,
                'destroy-location' => true,

                'store-product' => true,
                'create-product' => true,
                'edit-product' => true,
                'index-product' => true,
                'show-product' => true,
                'update-product' => true,
                'destroy-product' => true,

                'index-product_variation' => true,
                'create-product_variation' => true,
                'edit-product_variation' => true,
                'show-product_variation' => true,
                'update-product_variation' => true,
                'store-product_variation' => true,
                'destroy-product_variation' => true,

                'index-product_variation_type' => true,
                'create-product_variation_type' => true,
                'edit-product_variation_type' => true,
                'show-product_variation_type' => true,
                'update-product_variation_type' => true,
                'store-product_variation_type' => true,
                'destroy-product_variation_type' => true,

                'store-category' => true,
                'edit-category' => true,
                'create-category' => true,
                'show-category' => true,
                'update-category' => true,
                'destroy-category' => true,

                'store-review' => true,
                'destroy-review' => true,
                'update-review' => true,

                'store-comment' => true,
                'update-comment' => true,
                'show-comment' => true,
                'destroy-comment' => true,

                'store-user' => true,
                'create-user' => true,
                'edit-user' => true,
                'show-user' => true,
                'destroy-user' => true,
                'index-user' => true,
                'update-user' => true,

                'index-notification' => true,
                'update-notification' => true,

            ],
        ]);
        Role::create([
            'name' => 'User',
            'slug' => 'user',
            'permissions' => [
                'store-competition' => true,
                'show-competition' => true,
                'destroy-competition' => false,
                'index-competition' => true,
                'update-competition' => true,

                'store-review' => true,
                'destroy-review' => true,
                'update-review' => true,

                'store-comment' => true,
                'update-comment' => true,
                'show-comment' => true,
                'destroy-comment' => true,

                'store-feed' => true,
                'update-feed' => true,
                'create-feed' => true,
                'edit-feed' => true,
                'show-feed' => true,
                'index-feed' => true,
                'destroy-feed' => true,

                'store-location' => true,
                'create-location' => true,
                'edit-location' => true,
                'index-location' => true,
                'show-location' => true,
                'update-location' => true,
                'destroy-location' => true,

                'store-child' => true,
                'show-child' => true,
                'destroy-child' => true,
                'index-child' => true,
                'update-child' => true,
                'store-user' => false,
                'show-user' => true,
                'destroy-user' => false,
                'index-user' => false,
                'update-user' => true,
                'index-notification' => true,
                'update-notification' => true,

            ],
        ]);
    }
}

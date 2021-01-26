<?php

namespace App\Domain\Product\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Product\Entities\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->count(100)->create();
    }
}

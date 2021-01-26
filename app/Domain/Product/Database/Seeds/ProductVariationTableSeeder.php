<?php

namespace App\Domain\Product\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Product\Entities\ProductVariation;

class ProductVariationTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        ProductVariation::factory(1000)->times(50);
    }
}

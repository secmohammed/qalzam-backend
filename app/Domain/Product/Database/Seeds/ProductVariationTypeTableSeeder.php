<?php

namespace App\Domain\Product\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Product\Entities\ProductVariationType;

class ProductVariationTypeTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        ProductVariationType::factory(1000)->times(50);
    }
}

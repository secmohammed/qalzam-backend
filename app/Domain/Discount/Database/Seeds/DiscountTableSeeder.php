<?php

namespace App\Domain\Discount\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Discount\Entities\Discount;

class DiscountTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Discount::class,1000)->create();
    }
}

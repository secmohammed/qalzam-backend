<?php

namespace App\Domain\Product\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Product\Entities\Stock;

class StockTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Stock::factory(1000)->times(50);
    }
}

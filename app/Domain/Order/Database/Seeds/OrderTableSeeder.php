<?php

namespace App\Domain\Order\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Order\Entities\Order;

class OrderTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Order::factory(1000)->times(50);
    }
}

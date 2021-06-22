<?php

namespace App\Domain\Payment\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Payment\Entities\Payment;

class PaymentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Payment::factory(1000)->times(50);
    }
}

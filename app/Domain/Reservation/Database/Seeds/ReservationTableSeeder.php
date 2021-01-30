<?php

namespace App\Domain\Reservation\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Reservation\Entities\Reservation;

class ReservationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Reservation::factory(1000)->times(50);
    }
}

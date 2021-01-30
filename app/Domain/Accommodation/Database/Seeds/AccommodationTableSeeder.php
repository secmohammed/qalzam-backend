<?php

namespace App\Domain\Accommodation\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Accommodation\Entities\Accommodation;

class AccommodationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Accommodation::factory(1000)->times(50);
    }
}

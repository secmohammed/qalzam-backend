<?php

namespace App\Domain\Location\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Location\Entities\Location;

class LocationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        factory(Location::class,1000)->create();
    }
}

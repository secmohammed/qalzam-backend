<?php

namespace App\Domain\User\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\User\Entities\Address;

class AddressTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Address::factory(1000)->times(50);
    }
}

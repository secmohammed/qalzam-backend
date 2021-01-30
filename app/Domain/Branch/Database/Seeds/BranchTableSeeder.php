<?php

namespace App\Domain\Branch\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Branch\Entities\Branch;

class BranchTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Branch::factory(1000)->times(50);
    }
}

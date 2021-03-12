<?php

namespace App\Domain\Branch\Database\Seeds;

use App\Domain\Branch\Entities\Branch;
use Illuminate\Database\Seeder;

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

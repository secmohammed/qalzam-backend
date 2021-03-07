<?php

namespace App\Domain\Branch\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Branch\Entities\BranchShift;

class BranchShiftTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        BranchShift::factory(1000)->times(50);
    }
}

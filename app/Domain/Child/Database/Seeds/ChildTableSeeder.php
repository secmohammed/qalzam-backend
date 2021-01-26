<?php

namespace App\Domain\Child\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Child\Entities\Child;

class ChildTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Child::factory(1000)->times(50);
    }
}

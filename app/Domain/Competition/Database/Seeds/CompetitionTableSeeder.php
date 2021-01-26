<?php

namespace App\Domain\Competition\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Competition\Entities\Competition;

class CompetitionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Competition::factory(1000)->times(50);
    }
}

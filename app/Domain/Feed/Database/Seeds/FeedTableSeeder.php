<?php

namespace App\Domain\Feed\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Feed\Entities\Feed;

class FeedTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Feed::factory(1000)->times(50);
    }
}

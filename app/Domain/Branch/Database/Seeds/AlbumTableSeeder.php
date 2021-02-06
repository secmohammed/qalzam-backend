<?php

namespace App\Domain\Branch\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Branch\Entities\Album;

class AlbumTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Album::factory(1000)->times(50);
    }
}

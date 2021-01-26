<?php

namespace App\Domain\Message\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Message\Entities\Message;

class MessageTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Message::factory(1000)->times(50);
    }
}

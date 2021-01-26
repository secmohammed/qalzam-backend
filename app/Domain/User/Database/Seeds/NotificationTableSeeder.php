<?php

namespace App\Domain\User\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\User\Entities\Notification;

class NotificationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Notification::factory(1000)->times(50);
    }
}

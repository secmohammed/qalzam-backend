<?php

namespace App\Domain\Category\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Category\Entities\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Category::factory()->count(10)->create();
    }
}

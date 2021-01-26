<?php

namespace App\Domain\Ingredient\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Domain\Ingredient\Entities\Ingredient;

class IngredientTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Ingredient::factory(1000)->times(50);
    }
}

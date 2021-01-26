<?php

namespace App\Domain\Ingredient\Entities;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Ingredient\Repositories\Contracts\IngredientRepository;
use App\Domain\Ingredient\Entities\Traits\Relations\IngredientRelations;
use App\Domain\Ingredient\Entities\Traits\CustomAttributes\IngredientAttributes;

class Ingredient extends Model implements HasMedia
{
    use IngredientRelations, IngredientAttributes, HasFactory, InteractsWithMedia;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'user_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Ingredient';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = IngredientRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "ingredients";

    public static function newFactory()
    {
        return app(\App\Domain\Ingredient\Database\Factories\IngredientFactory::class)->new();
    }
}

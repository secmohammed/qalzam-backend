<?php

namespace App\Domain\Category\Entities;

use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Joovlly\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Category\Repositories\Contracts\CategoryRepository;
use App\Domain\Category\Entities\Traits\Relations\CategoryRelations;
use App\Domain\Category\Entities\Traits\CustomAttributes\CategoryAttributes;

class Category extends Model implements HasMedia
{
    use CategoryRelations, CategoryAttributes, NodeTrait, HasFactory, InteractsWithMedia, Translatable;

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
        'type',
        'status',
        'parent_id',
    ];

    /**

     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Category';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = CategoryRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "categories";

    /**
     * @var array
     */
    protected static $translatables = ['name'];

    public static function newFactory()
    {
        return app(\App\Domain\Category\Database\Factories\CategoryFactory::class)->new();
    }
}

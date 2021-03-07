<?php

namespace App\Domain\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Product\Repositories\Contracts\TemplateRepository;
use App\Domain\Product\Entities\Traits\Relations\TemplateRelations;
use App\Domain\Product\Entities\Traits\CustomAttributes\TemplateAttributes;

class Template extends Model
{
    use TemplateRelations, TemplateAttributes, HasFactory;

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
        'user_id',
        'status',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Template';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = TemplateRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "templates";

    public static function newFactory()
    {

        return app(\App\Domain\Product\Database\Factories\TemplateFactory::class)->new();
    }
}

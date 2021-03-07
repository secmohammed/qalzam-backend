<?php

namespace App\Domain\Branch\Entities;

use Spatie\MediaLibrary\HasMedia;
use App\Common\Traits\FetchesMediaCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Branch\Repositories\Contracts\AlbumRepository;
use App\Domain\Branch\Entities\Traits\Relations\AlbumRelations;
use App\Domain\Branch\Entities\Traits\CustomAttributes\AlbumAttributes;

class Album extends Model implements HasMedia
{
    use AlbumRelations, AlbumAttributes, FetchesMediaCollection, HasFactory;

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
        'branch_id',
        'status',
        'user_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Album';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = AlbumRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "albums";

    public static function newFactory()
    {
        return app(\App\Domain\Branch\Database\Factories\AlbumFactory::class)->new();
    }
}

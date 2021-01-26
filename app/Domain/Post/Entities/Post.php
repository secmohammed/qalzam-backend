<?php

namespace App\Domain\Post\Entities;

use Spatie\MediaLibrary\HasMedia;
use Joovlly\Reviewable\Traits\HasReviews;
use Joovlly\Commentable\Traits\HasComments;
use Spatie\MediaLibrary\InteractsWithMedia;
use Joovlly\Translatable\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Post\Repositories\Contracts\PostRepository;
use App\Domain\Post\Entities\Traits\Relations\PostRelations;
use App\Domain\Post\Entities\Traits\CustomAttributes\PostAttributes;

class Post extends Model implements HasMedia
{
    use PostRelations, PostAttributes, HasFactory, HasComments, HasReviews, InteractsWithMedia, Translatable;

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
        'title',
        'description',
        'status',
        'type',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Post';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = PostRepository::class;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "posts";

    /**
     * @var array
     */
    protected static $translatables = ['title', 'description'];

    /**
     * @var array
     */
    protected $withCount = ['reviews', 'comments'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function newFactory()
    {
        return app(\App\Domain\Post\Database\Factories\PostFactory::class)->new();
    }
}

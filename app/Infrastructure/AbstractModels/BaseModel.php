<?php

namespace App\Infrastructure\AbstractModels;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**

     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = null;

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = null;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = null;

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define belongsToMany relations.
     *
     * @var array
     */
    private $belongsToMany = [];

    /**
     * define hasMany relations.
     *
     * @var array
     */
    private $hasMany = [];

    /**
     * define HasOne relations.
     *
     * @var array
     */
    private $hasOne = [];

    /**
     * define MorphMany relations.
     *
     * @var array
     */
    private $morphMany = [];

    /**
     * define MorphTo relations.
     *
     * @var array
     */
    private $morphOne = [];

    /**
     * define MorphTo relations.
     *
     * @var boolean
     */
    private $morphTo = false;

    /**
     * define morphToMany relations.
     *
     * @var array
     */
    private $morphToMany = [];

    /**
     * define morphedByMany relations.
     *
     * @var array
     */
    private $morphedByMany = [];

    /**
     * @param $key
     * @return mixed
     */
    public function getArAttribute($key)
    {
        if ($this->translations->first() !== null) {
            return $this->translations->first()->where('key', $key)->where('translatable_id', $this->id)->first()->value ?? '';
        } else {
            return '';
        }
    }

    /**

     * Reolve Route Binding Using Repo
     *
     * @param string $value
     * @param mix $field
     * @return mix
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($this->routeRepoBinding) {
            $repo = app()->make($this->routeRepoBinding);

            return $repo->spatie()->where([$this->getRouteKeyName() => $value])->firstOrFail();
        }

        return $this->where('id', $value)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @param array $options
     */
    public function update(array $attributes = [], array $options = [])
    {
        return tap($this, function () use ($attributes, $options) {
            parent::update($attributes, $options);
        });
    }
}

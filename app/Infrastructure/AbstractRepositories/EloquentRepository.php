<?php
namespace App\Infrastructure\AbstractRepositories;

use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Contracts\Container\Container as Application;

abstract class EloquentRepository extends BaseRepository
{
    /**
     * Allowed Appends.
     *
     * @var array
     */
    protected $allowedAppends = [];

    /**
     * Allowed Fields.
     *
     * @var array
     */
    protected $allowedFields = [];

    /**
     * Allowed Relations To Be Included.
     *
     * @var array
     */
    protected $allowedFilters = [];

    /**
     * Allowed Relations To Be Included.
     *
     * @var array
     */
    protected $allowedFiltersExact = [];

    /**
     * Allowed Relations To Be Included.
     *
     * @var array
     */
    protected $allowedIncludes = [];

    /**
     * Allowed Sorts.
     *
     * @var array
     */
    protected $allowedSorts = [];

    /**

     * Retrieve all data of repository.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        if ($this->model instanceof Builder || $this->model instanceof QueryBuilder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }
        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    /**
     * @param $ids
     */
    public function destroy($ids)
    {
        $ids = explode(',', $ids);
        $items = $this->whereIn($this->getRouteKeyName(), $ids);
        $records = $items->get();
        $items->delete();

        return $records;
    }

    /**
     * @param Application $app
     */
    public function spatie()
    {
        foreach ($this->allowedFiltersExact as $field) {
            array_push($this->allowedFilters, AllowedFilter::exact($field));
        }
        if ($this->model instanceof Builder) {
            $this->model = QueryBuilder::for ($this->model)
                    ->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedIncludes($this->allowedIncludes)->allowedSorts($this->allowedSorts);

            if (in_array('status', app($this->model())->getFillable()) && !Str::endsWith($this->model(), ['Feed', 'Post', 'Order'])  && request()->wantsJson()) {
                $this->model = $this->model->where(app($this->model())->getTable() . '.status', 'active');
            }
            if (in_array('status', app($this->model())->getFillable()) && Str::endsWith($this->model(), 'Post') && request()->wantsJson()) {
                $this->model = $this->model->where(app($this->model())->getTable(). '.status', 'approved');
            }

        } else {
            $model = $this->model;
            $this->model = QueryBuilder::for ($this->model())
                    ->allowedFields($this->allowedFields)->allowedFilters($this->allowedFilters)->allowedIncludes($this->allowedIncludes)->allowedSorts($this->allowedSorts);

            if (in_array('status', $model->getFillable()) && !Str::endsWith($this->model(), ['Feed', 'Post', 'Order']) && request()->wantsJson()) {
                $this->model = $this->model->where(app($this->model())->getTable() . '.status', 'active');
            }
            if (in_array('status', app($this->model())->getFillable()) && Str::endsWith($this->model(), 'Post') && request()->wantsJson()) {
                $this->model = $this->model->where(app($this->model())->getTable() . '.status', 'approved');
            }

        }

        return $this;
    }
};

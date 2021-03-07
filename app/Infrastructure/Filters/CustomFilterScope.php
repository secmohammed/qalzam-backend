<?php

namespace App\Infrastructure\Filters;

use ReflectionObject;
use ReflectionException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Exceptions\InvalidFilterValue;

class CustomFilterScope implements Filter
{
    /**
     * @param Builder $query
     * @param $values
     * @param string $property
     * @return mixed
     */
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $scope = Str::camel($property);
        $values = $this->resolveParameters($query, $value, $scope);

        return $query->$scope($values);
    }

    /**
     * @param Builder $query
     * @param $values
     * @param string $scope
     * @return mixed
     */
    protected function resolveParameters(Builder $query, $values, string $scope): array
    {
        try {
            $parameters = (new ReflectionObject($query->getModel()))
                ->getMethod('scope' . ucfirst($scope))
                ->getParameters();
        } catch (ReflectionException $e) {
            return $values;
        }

        foreach ($parameters as $parameter) {
            if (!optional($parameter->getClass())->isSubclassOf(Model::class)) {
                continue;
            }

            $model = $parameter->getClass()->newInstance();
            $index = $parameter->getPosition() - 1;
            $value = $values[$index];

            $result = $model->resolveRouteBinding($value);

            if ($result === null) {
                throw InvalidFilterValue::make($value);
            }

            $values[$index] = $result;
        }

        return $values ?? [];
    }
}

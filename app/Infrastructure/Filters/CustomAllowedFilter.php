<?php

namespace App\Infrastructure\Filters;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Infrastructure\Filters\CustomFilterScope;

class CustomAllowedFilter extends AllowedFilter
{
    /**
     * @param QueryBuilder $query
     * @param $value
     */
    public function filter(QueryBuilder $query, $value = null)
    {
        $valueToFilter = $this->resolveValueForFiltering($value);
        ($this->filterClass)($query, $valueToFilter, $this->internalName);

    }

    /**
     * @param string $name
     * @param $internalName
     */
    public static function scope(string $name, $internalName = null): self
    {
        return new static($name, new CustomFilterScope, $internalName);
    }
}

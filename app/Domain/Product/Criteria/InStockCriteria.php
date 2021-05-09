<?php

namespace App\Domain\Product\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class StatusIsActiveCriteria.
 *
 * @package namespace App\Criteria;
 */
class InStockCriteria implements CriteriaInterface
{
    protected $status ;

    public function __construct(bool $is_active = true)
    {
        $this->status = $is_active ? 'active' : 'inactive';
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('stocks', function ($stock){
            $stock->in_stock  > 0;
        });
    }
}

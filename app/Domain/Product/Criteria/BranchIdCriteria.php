<?php

namespace App\Domain\Product\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class StatusIsActiveCriteria.
 *
 * @package namespace App\Criteria;
 */
class BranchIdCriteria implements CriteriaInterface
{
    public $branchId;

    public function __construct($branchId)
    {
        $this->branchId = $branchId;
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
        $branchId = $this->branchId;
        return $model->whereHas('branches', function ($branches) use ($branchId){
            return $branches->where('branch_id', $branchId);
        });
    }
}

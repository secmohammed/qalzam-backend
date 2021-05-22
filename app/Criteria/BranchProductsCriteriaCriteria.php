<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class BranchProductsCriteriaCriteria.
 *
 * @package namespace App\Criteria;
 */
class BranchProductsCriteriaCriteria implements CriteriaInterface
{
    protected $branch_id;
    public function __construct($branch_id)
    {
        $this->branch_id = $branch_id;
    }

    /**
     * Apply criteria in query repository
     * Get Branch Products for  App\Domain\Product\Entities\Product
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $branch_id = $this->branch_id;
        return $model->whereHas('variations.branches', function ($branch)  use ($branch_id){
            return $branch->where('branch_id', $branch_id) ;
        });
    }
}

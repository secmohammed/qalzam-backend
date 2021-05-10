<?php

namespace App\Domain\Branch\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class BranchHasGalleriesCriteria.
 *
 * @package namespace App\Criteria;
 */
class BranchHasGalleriesCriteria implements CriteriaInterface
{
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
        return $model->has('albums');
    }
}

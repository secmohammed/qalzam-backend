<?php

namespace App\Common\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class StatusIsActiveCriteria.
 *
 * @package namespace App\Criteria;
 */
class StatusIsCriteria implements CriteriaInterface
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
        return $model->where('status', $this->status);
    }
}

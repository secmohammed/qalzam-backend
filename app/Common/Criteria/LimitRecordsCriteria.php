<?php

namespace App\Common\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LimitRecordsCriteria.
 *
 * @package namespace App\Criteria;
 */
class LimitRecordsCriteria implements CriteriaInterface
{
    protected $limit;

    public function __construct(int $limit = 20)
    {
        $this->limit = $limit;
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
        return $model->limit($this->limit);
    }
}

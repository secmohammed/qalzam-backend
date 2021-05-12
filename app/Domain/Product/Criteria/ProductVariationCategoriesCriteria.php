<?php

namespace App\Domain\Product\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ProductVariationCategoriesCriteria.
 *
 * @package namespace App\Criteria;
 */
class ProductVariationCategoriesCriteria implements CriteriaInterface
{
    public $category_id;
    public function __construct($category_id)
    {
        $this->category_id = $category_id;
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
        $category_id = $this->category_id;
        return $model->whereHas('product', function ($products) use ($category_id) {
            return $products->where('status', 'active')->whereHas('categories', function ($categories) use($category_id) {
                return $categories->where(['id' => $category_id ,'type' => 'products']);
            });
        });
    }
}

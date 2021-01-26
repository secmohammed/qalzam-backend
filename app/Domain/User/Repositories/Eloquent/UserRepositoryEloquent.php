<?php

namespace App\Domain\User\Repositories\Eloquent;

use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\AbstractRepositories\EloquentRepository;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends EloquentRepository implements UserRepository
{
    /**
     * Specify Fields
     *
     * @return string
     */
    protected $allowedFields = [
        ###allowedFields###
        ###\allowedFields###
    ];

    /**
     * Include Relationships
     *
     * @return string
     */
    protected $allowedIncludes = [
        'users',
        'children',
        'wishlist',
        'cart',
        'wishlist.product',
        'cart.product',
        'wishlist.product.variations',
        'cart.product.variations',
        'cart.product.variations.stock',
        'wishlist.type',
        'cart.type',
        'addresses',
        'categories',
        'deviceTokens',
        'orders',
        'products',
        'roles',
        'feeds',
        'feeds.media',

    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Specify Model Relationships
     *
     * @return string
     */
    public function relations()
    {
        return [
            ###allowedRelations###
            ###\allowedRelations###
        ];
    }
}

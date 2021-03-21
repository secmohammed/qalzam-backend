<?php

namespace App\Domain\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Infrastructure\AbstractModels\BaseModel as Model;
use App\Domain\Order\Repositories\Contracts\OrderRepository;
use App\Domain\Order\Entities\Traits\Relations\OrderRelations;
use App\Domain\Order\Entities\Traits\CustomAttributes\OrderAttributes;

class Order extends Model
{
    use OrderRelations, OrderAttributes, HasFactory;

    const COMPLETED = 'completed';

    const PAYMENT_FAILED = 'payment_failed';

    const PENDING = 'pending';

    const PROCESSING = 'processing';

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'address_id',
        // 'shipping_method_id',
        // 'payment_method_id',
        'subtotal',
        'branch_id',
        'creator_id',
        'user_id',
    ];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'Order';

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = OrderRepository::class;

    /**

     * Reolve Route Binding Using Repo
     *
     * @param string $value
     * @param mix $field
     * @return mix
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($this->routeRepoBinding) {
            $repo = app()->make($this->routeRepoBinding);

            return $repo->spatie()->where([$this->getRouteKeyName() => $value])->deliverersWithFee()->firstOrFail();
        }

        return $this->where('id', $value)->firstOrFail();
    }
    /**
     * The table name.
     *
     * @var array
     */
    protected $table = "orders";

    public static function newFactory()
    {
        return app(\App\Domain\Order\Database\Factories\OrderFactory::class)->new();
    }
}

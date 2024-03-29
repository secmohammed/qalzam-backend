<?php

namespace App\Domain\User\Http\Resources\User;

use App\Common\Cart\Cart;
use App\Domain\Discount\Http\Resources\Discount\DiscountResource;
use App\Domain\Reservation\Http\Resources\Reservation\ReservationResource;
use App\Domain\User\Entities\User;
use App\Domain\User\Http\Resources\Address\AddressResource;
use App\Domain\User\Http\Resources\Address\AddressResourceCollection;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;
use Illuminate\Http\Request;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function data(Request $request): array
    {
        $meta = [];
        if (($cart = app(Cart::class))->user && $cart->hasBranch() && $cart->getType() === 'cart') {

            $meta = [
                'meta' => [
                    'cart' => [
                        'empty' => $cart->isEmpty(),
                        'subtotal' => $cart->subtotal()->formatted(),
                        'vat' => $cart->vat()->formatted(),
                        'delivery_fee' => $cart->deliveryFee()->formatted(),
                        'total' => $cart->total()->formatted(),
                        'changed' => $cart->hasChanged(),
                        'discount' => $cart->discountValue()->formatted(),
                        'discount_id' => $cart->getDiscountId(),
                    ],

                ],

            ];
        }

        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'name_ar' => $this->name,
            'mobile' => $this->mobile,
            'avatar' => $this->getFirstMediaUrl('image'),
            'created_at_human' => $this->created_at->diffForHumans(),
            'wishlist' => new WishlistResource($this->whenLoaded('wishlist')),
            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
            'discounts' => DiscountResource::collection($this->whenLoaded('discounts')),
            $this->mergeWhen(array_key_exists('roles', $this->getRelations()), [
                'permissions' => array_merge($this->roles->sortByDesc('created_at')->pluck('permissions')->collapse()->toArray(), $this->permissions ?? []),
            ]),
            'reservations' => ReservationResource::collection($this->whenLoaded('reservations')),
            'cart' => (new CartResource($cart->hasType()?$cart->products() : $this->whenLoaded('cart')))->additional($meta ?? []),
            // 'cart' => (new CartResource($this->whenLoaded('cart')))->additional($meta ?? []),
        ] + $meta;
    }
}

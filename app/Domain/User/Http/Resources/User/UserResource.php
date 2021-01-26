<?php

namespace App\Domain\User\Http\Resources\User;

use App\Common\Cart\Cart;
use Illuminate\Http\Request;
use App\Domain\User\Entities\User;
use App\Domain\Feed\Http\Resources\Feed\FeedResource;
use App\Domain\User\Http\Resources\User\CartResource;
use App\Domain\Child\Http\Resources\Child\ChildResource;
use App\Domain\User\Http\Resources\User\WishlistResource;
use App\Infrastructure\Http\AbstractResources\BaseResource as JsonResource;

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
        if (($cart = app(Cart::class))->user) {
            $meta = [
                'meta' => [
                    'cart' => [
                        'empty' => $cart->isEmpty(),
                        'subtotal' => $cart->subtotal()->formatted(),
                        'total' => $cart->total()->formatted(),
                        'changed' => $cart->hasChanged(),

                    ],

                ],

            ];
        }

        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'avatar' => $this->getFirstMediaUrl('avatar'),
            'created_at_human' => $this->created_at->diffForHumans(),
            'children' => ChildResource::collection($this->whenLoaded('children')),
            'feeds' => FeedResource::collection($this->whenLoaded('feeds')),
            'wishlist' => new WishlistResource($this->whenLoaded('wishlist')),
            $this->mergeWhen(array_key_exists('roles', $this->getRelations()), [
                'permissions' => array_merge($this->roles->sortByDesc('created_at')->pluck('permissions')->collapse()->toArray(), $this->permissions ?? []),
            ]),
            'cart' => (new CartResource($this->whenLoaded('cart')))->additional($meta ?? []),
        ] + $meta;
    }
}

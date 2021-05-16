<div class="col-sm-3 item">
    <livewire:card.vertical-card
        :product="$product"
        :productPrice="$product->pivot->price"
        :productImage="$product->getLastMediaUrl('product_variation-images') ?: asset('/assets/website/images/slider/img-1.jpg')"
        :productId="$product->id"
        :action="$action"
        :key="'branch-single-product-'. $product->id"
    />
</div>

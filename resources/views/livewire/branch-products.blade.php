<div class="row">
@foreach($products as $index => $product)
    <livewire:card.vertical-card
        :product="$product"
        :productPrice="$product->pivot->price"
        :productImage="$product->getLastMediaUrl('product_variation-images') ?: asset('/assets/website/images/slider/img-1.jpg')"
        :productId="$product->id"
        :productName="$product->name"
        :action="$action"
        :key="'branch-vertical-card-'. $product->id"
    />
@endforeach
</div>

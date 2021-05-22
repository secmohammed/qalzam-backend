<div class="row">
{{--    {{dd($rendProducts)}}--}}
@foreach($products as $index => $product)
{{--    {{dd($products)}}--}}

    <livewire:card.vertical-card
        :productPrice="$product->price->formatted()"
        :productImage="$product->getLastMediaUrl('product-images') ?: asset('/assets/website/images/slider/img-1.jpg')"
        :productId="$product->id"
        :productName="$product->name"
        :action="route('website.show.product', ['product_variation' => $product->id])"
        :button="'add-to-cart'"
        :key="'branch-vertical-card-'. $product->id"
    />
@endforeach
</div>

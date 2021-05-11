<div class="row">
@foreach($products as $index => $product)
    <livewire:card.vertical-card
        :product="$product"
        :action="$action"
        key="'horizontal-product-'. $product->id"
    />
@endforeach
</div>

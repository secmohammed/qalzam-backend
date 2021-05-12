<div class="row">
@foreach($products as $index => $product)
    <livewire:branch.single-product
        :product="$product"
        :action="$action"
        :key="'single-product-'.$product->id"
    />
@endforeach
</div>

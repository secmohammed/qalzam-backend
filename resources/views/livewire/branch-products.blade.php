@foreach($products as $index => $product)
    <livewire:card.vertical-card
        :product="$product"
        :action="$action"
        :wire:key="'horizontal-product-'. $product->id"
    />
@endforeach

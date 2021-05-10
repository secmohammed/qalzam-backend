{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
@foreach($products as $index => $product)
    <livewire:card.horizontal-card
        :product="$product"
        :wire:key="'horizontal-product-'. $product->id"
    />
@endforeach

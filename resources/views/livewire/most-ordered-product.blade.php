{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
@foreach($products as $index => $product)
        <livewire:card.vertical-card
            :product="$product"
            :productPrice="$product->price->amount()"
            :productImage="$product->getLastMediaUrl('product_variation-images') ?: asset('/assets/website/images/slider/img-1.jpg')"
            :productId="$product->id"
            :productName="$product->name"
            :action="{{route('website.branches')}}"
            :key="'vertical-card-'. $product->id"
        />
@endforeach
@if($pagination === 'true')
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">
                <svg width="12" height="12" viewBox="0 0 6 11" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.07119 5.26116L0.725649 9.73753C0.57542 9.89231 0.57542 10.1432 0.725649 10.298C0.875924 10.4527 1.1195 10.4527 1.26975 10.298L5.88735 5.5414C6.03755 5.38662 6.03755 5.13569 5.88735 4.98092L1.26975 0.224302C1.11688 0.0722204 0.873287 0.0765873 0.72565 0.234057C0.581644 0.387672 0.581644 0.631193 0.72565 0.784784L5.07119 5.26116Z"></path>
                </svg></a></li>
        <li class="page-item"><a class="page-link active" href="#">1 </a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">
                <svg width="12" height="12" viewBox="0 0 6 11" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.928806 5.2657L5.27435 0.789322C5.42458 0.634546 5.42458 0.383616 5.27435 0.22884C5.12408 0.0741106 4.8805 0.0741106 4.73025 0.22884L0.112655 4.98546C-0.0375518 5.14023 -0.0375518 5.39116 0.112655 5.54594L4.73025 10.3026C4.88312 10.4546 5.12671 10.4503 5.27435 10.2928C5.41836 10.1392 5.41836 9.89566 5.27435 9.74207L0.928806 5.2657Z"></path>
                </svg></a></li>
    </ul>
@endif

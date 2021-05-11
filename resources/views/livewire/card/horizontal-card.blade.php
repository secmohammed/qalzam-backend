<div class="item">
    <a href="#">
        <div class="photo"><img src="{{$product->getLastMediaUrl('product_variation-images') ?: asset('/assets/website/images/slider/img-1.jpg')}}" alt=""></div>
        <div class="content">
            <h2 class="title">{{$product->name}}<br/>البحر</h2>
            <p class="price">{{$product->price->amount()}} ريال </p>
        </div></a>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
</div>

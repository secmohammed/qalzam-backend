<div class="row" >
    <div class="col-sm-5 item-inner">
        <div class="carousel slide carousel-fade" id="carouselExampleIndicators" data-ride="carousel">
            <div class="carousel-inner">
{{--                <div class="carousel-item active"><img src="images/slider/img-1.jpg" alt=""></div>--}}
{{--                <div class="carousel-item">       <img src="images/slider/img-2.jpg" alt=""></div>--}}
{{--                <div class="carousel-item">       <img src="images/slider/img-3.jpg" alt="">     </div>--}}
                @foreach($product->getMediaCollectionUrl('product-images') as $index => $url)
                    <div class="carousel-item {{$index == 0 ? 'active' : ''}}"><img src="{{$url}}" alt=""></div>
                @endforeach
            </div>
            @if(count($product->getMediaCollectionUrl('product-images')) > 1)
                <ol class="carousel-indicators">
                    @foreach($product->getMediaCollectionUrl('product-images') as $index => $url)
                        <li class="{{$index == 0 ? 'active' : ''}}" data-target="#carouselExampleIndicators" data-slide-to="{{$index}}"><img src="{{$url}}" alt=""></li>
                    @endforeach
                </ol>
            @endif
        </div>
    </div>
    <div class="col-sm-7 item-inner">
        <h2 class="title">{{$productVariationName}} </h2>
        <p class="text">{{$product->description}}</p> <!-- todo change it to product variation description -->
        <div class="listorder">
            <h3 class="title"> {{$this->productName}}</h3>
            <livewire:product-variation-types
                :variationTypes="$this->variationTypes"
                :key="'product-variation-types'"
            />
{{--            <nav class="list-filter">--}}
{{--                @foreach($this->variationTypes as $index => $type)--}}
{{--                    <a class="{{$index == 0 ? 'active' : ''}}" href="#" wire:click="changeVariationType({{$type->id}})">{{$type->name}}</a>--}}
{{--                @endforeach--}}
{{--            </nav>--}}
            <p class="text">يحتوي علي ١٥٠٠ سعر حراري</p>
        </div>
        <p class="price">{{$productVariationPrice}}</p>
        <div class="ac-bot">
            <form class="spinner" action="#" method="">
                <button class="btn btn-default ault" type="button"wire:click="increaseQuantity"  >
                    <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.88413 5.16H5.79613V8.344H4.00413V5.16H0.948125V3.64H4.00413V0.44H5.79613V3.64H8.88413V5.16Z" fill="#707070"></path>
                    </svg>
                </button>
                <input class="form-control" type="text" value="{{$quantity}}">
                <button class="btn btn-default" type="button"wire:click="decreaseQuantity" >
                    <svg width="5" height="3" viewBox="0 0 5 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.87425 2.32H0.02625V0.72H4.87425V2.32Z" fill="#707070"></path>
                    </svg>
                </button>
            </form><a class="addcard" href="#{{$productVariationId}}" wire:click="addToCart()" >
                <svg width="24" height="24" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.7922 4.06045C13.6073 3.82852 13.3299 3.69547 13.0312 3.69547H10.335L8.87294 0.347692C8.78229 0.140125 8.54052 0.0452699 8.33293 0.135969C8.12533 0.226614 8.03053 0.468415 8.1212 0.676008L9.43986 3.6955H4.56015L5.8788 0.676008C5.96944 0.468415 5.87467 0.226641 5.66708 0.135969C5.45951 0.0452699 5.21771 0.140071 5.12706 0.347692L3.66502 3.6955H0.968818C0.67006 3.6955 0.392713 3.82852 0.207842 4.06048C0.0263611 4.2882 -0.0406037 4.58094 0.0241189 4.86373L1.46396 11.1528C1.5645 11.5919 1.95297 11.8986 2.40866 11.8986H11.5913C12.047 11.8986 12.4355 11.5919 12.536 11.1528L13.9759 4.8637C14.0406 4.58091 13.9736 4.28817 13.7922 4.06045ZM11.5913 11.0783H2.40866C2.33901 11.0783 2.27801 11.0326 2.2636 10.9697L0.823759 4.68066C0.812467 4.63131 0.831416 4.59418 0.849353 4.57173C0.865978 4.55084 0.903631 4.51581 0.968818 4.51581H3.30679L3.19936 4.76182C3.10871 4.96941 3.20349 5.21119 3.41108 5.30186C3.46451 5.32521 3.52018 5.33626 3.57501 5.33626C3.73311 5.33626 3.88377 5.2443 3.95109 5.09017L4.20192 4.51586H9.79814L10.049 5.09017C10.1163 5.24433 10.267 5.33626 10.4251 5.33626C10.4798 5.33626 10.5355 5.32521 10.589 5.30186C10.7966 5.21122 10.8914 4.96941 10.8007 4.76182L10.6933 4.51581H13.0312C13.0964 4.51581 13.1341 4.55084 13.1507 4.57173C13.1686 4.5942 13.1876 4.63134 13.1763 4.68064L11.7365 10.9697C11.722 11.0326 11.661 11.0783 11.5913 11.0783Z" fill="#fff"></path>
                    <path d="M4.53906 6.29297C4.31255 6.29297 4.12891 6.47661 4.12891 6.70313V9.71094C4.12891 9.93745 4.31255 10.1211 4.53906 10.1211C4.76558 10.1211 4.94922 9.93745 4.94922 9.71094V6.70313C4.94922 6.47661 4.76561 6.29297 4.53906 6.29297Z" fill="#fff"></path>
                    <path d="M7 6.29297C6.77348 6.29297 6.58984 6.47661 6.58984 6.70313V9.71094C6.58984 9.93745 6.77348 10.1211 7 10.1211C7.22652 10.1211 7.41016 9.93745 7.41016 9.71094V6.70313C7.41016 6.47661 7.22652 6.29297 7 6.29297Z" fill="#fff"></path>
                    <path d="M9.46094 6.29297C9.23442 6.29297 9.05078 6.47661 9.05078 6.70313V9.71094C9.05078 9.93745 9.23442 10.1211 9.46094 10.1211C9.68745 10.1211 9.87109 9.93745 9.87109 9.71094V6.70313C9.87107 6.47661 9.68745 6.29297 9.46094 6.29297Z" fill="#fff"></path>
                </svg>إضافه إلي السله</a><a class="add-w" href="#">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0)">
                        <path d="M18.4406 3.16926C17.3875 2.09223 15.9788 1.49906 14.474 1.49906C12.9923 1.49906 11.5993 2.07613 10.5513 3.12414L10.0104 3.66535L9.46906 3.12398C8.42117 2.07609 7.02836 1.49902 5.54715 1.49902C4.06547 1.49902 2.67242 2.07609 1.62461 3.12398C0.576953 4.1716 0 5.56453 0 7.04621C0 8.52789 0.576953 9.92082 1.62461 10.9684L8.5575 17.9013C8.95801 18.3017 9.48395 18.502 10.01 18.502C10.5359 18.5019 11.062 18.3017 11.4624 17.9013L18.3506 11.0137C20.5141 8.85015 20.5545 5.33121 18.4406 3.16926ZM17.6243 10.2875L10.7361 17.1752C10.3357 17.5755 9.68414 17.5755 9.28375 17.1751L2.35082 10.2421C1.49715 9.38851 1.02703 8.25352 1.02703 7.04617C1.02703 5.83883 1.49715 4.70383 2.35082 3.85016C3.20465 2.99629 4.3398 2.52605 5.54715 2.52605C6.75402 2.52605 7.88895 2.99629 8.74281 3.85016L9.28445 4.3918L8.45504 5.22184C8.25457 5.42246 8.25473 5.74758 8.45531 5.94805C8.55559 6.04824 8.68691 6.09832 8.81828 6.09832C8.9498 6.09832 9.08125 6.04809 9.18152 5.94777L11.2775 3.85012C12.1314 2.99625 13.2665 2.52602 14.4739 2.52602C15.7 2.52602 16.8479 3.00945 17.7062 3.88723C19.4287 5.64883 19.3919 8.51992 17.6243 10.2875Z" fill="#D1362A"></path>
                    </g>
                </svg></a>
        </div>
    </div>
</div>

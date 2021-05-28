{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
<div class="itemcard" wire:ignore>
    <a class="delet-card" href="#" wire:click="removeProduct({{$productId}})">
        <svg width="6" height="6" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.66271 6.00002L11.8625 0.800231C12.0455 0.617161 12.0455 0.320349 11.8625 0.137303C11.6794 -0.0457441 11.3826 -0.0457675 11.1995 0.137303L5.99975 5.33709L0.799987 0.137303C0.616917 -0.0457675 0.320105 -0.0457675 0.137058 0.137303C-0.0459882 0.320373 -0.0460117 0.617185 0.137058 0.800231L5.33682 6L0.137058 11.1998C-0.0460117 11.3829 -0.0460117 11.6797 0.137058 11.8627C0.228582 11.9542 0.348558 12 0.468535 12C0.588511 12 0.708464 11.9542 0.800011 11.8627L5.99975 6.66295L11.1995 11.8627C11.291 11.9542 11.411 12 11.531 12C11.651 12 11.7709 11.9542 11.8625 11.8627C12.0455 11.6796 12.0455 11.3828 11.8625 11.1998L6.66271 6.00002Z" fill="#707070"></path>
        </svg>
    </a>
    <div class="item">
        <div class="photo"><img src="{{$productImage}}" alt=""></div>
        <div class="content"><span>{{$productCategory}}</span>
            <h2 class="title">{{$productName}}</h2>
            <p>{{$productVariationName}}</p>
        </div>
    </div>
    <p class="price">{{$productTotalPrice}}{{__('website.riyals')}}</p>
    <div class="spinner">
        <button class="btn btn-default ault" type="button" wire:click="increaseAmount({{$productId}})">
            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.88413 5.16H5.79613V8.344H4.00413V5.16H0.948125V3.64H4.00413V0.44H5.79613V3.64H8.88413V5.16Z" fill="#707070"></path>
            </svg>
        </button>
        <input class="form-control" type="text" value="{{$quantity}}">
        <button class="btn btn-default" type="button" wire:click="reduceAmount({{$productId}})">
            <svg width="5" height="3" viewBox="0 0 5 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.87425 2.32H0.02625V0.72H4.87425V2.32Z" fill="#707070"></path>
            </svg>
        </button>
    </div>
</div>

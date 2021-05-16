
{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
<form action="#" method="post">
    <!--div.alert.alert-success
    svg(width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg")
      path(d="M39.2853 18.2363V20.0106C39.2829 24.1694 37.9363 28.2161 35.4461 31.547C32.956 34.8779 29.4559 37.3147 25.4678 38.4939C21.4796 39.673 17.2172 39.5314 13.3161 38.0902C9.41497 36.6489 6.08427 33.9852 3.82072 30.4964C1.55717 27.0075 0.482036 22.8805 0.755672 18.7307C1.02931 14.5809 2.63705 10.6307 5.33912 7.46926C8.04119 4.30784 11.6928 2.10457 15.7494 1.18804C19.8059 0.271518 24.0501 0.690841 27.8489 2.38348M39.2853 4.58207L19.9996 23.8871L14.2139 18.1014" stroke="white" stroke-linecap="round" stroke-linejoin="round")
    div.contant
     p تم اتمام العملية بنجاح
    -->
    <!--div.alert.alert-danger
    svg(width="30" height="36" viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg")
     path(d="M30.3317 9.61971L31.7399 10.699C35.0394 13.2307 37.432 16.7611 38.5611 20.7637C39.6901 24.7664 39.4951 29.0267 38.005 32.9094C36.5149 36.7921 33.8097 40.0892 30.2927 42.3088C26.7757 44.5284 22.6355 45.5517 18.4894 45.226C14.3434 44.9003 10.4137 43.2431 7.28642 40.5016C4.15914 37.7601 2.00185 34.0812 1.13628 30.0134C0.270714 25.9457 0.743244 21.7071 2.4834 17.9299C4.22355 14.1526 7.1381 11.0391 10.7924 9.05358M20.4942 1.31382L20.7017 27.5582" stroke="white" stroke-linecap="round" stroke-linejoin="round")
    div.contant
     p هناك خطأ ما , يرجى إعاده المحاولة
    -->
    <div class="row">
        <div class="col-sm-8 item-basket">
            <div class="inner">
                @foreach($products as $product)
                    <livewire:card.cart-card
                        key="'my-cart-product-'.{{$product->id}}"
                        :quantity="$product['quantity']"
                        :productId="$product['id']"
                        :productName="$product['name']"
                        :productTotalPrice="$product['total_price']"
                        :productImage="$product->image ?: asset('assets/website/images/slider/img-1.jpg')"
                    />
                @endforeach
            </div>
        </div>
            <livewire:price-card :action="`{{route('website.finish-order')}}`" :method="'POST'"/>
    </div>
</form>

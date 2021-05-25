<div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
    <form action="#" method="post">
        <div class="inner">
            <div class="row">
                @foreach($addresses as $address)
                    <livewire:card.address-card
                        :city="$address->location->parent->name"
                        :district="$address->location->name"
                        :streetName="$address->name"
                        :landmark="$address->landmark"
                        :fullAddress="$address->address_1"
                        :addressId="$address->id"
                        key="'my-profile-address-card'.$address->id"
                    />
                @endforeach
                <div class="col-sm-3 add-address"><a class="add" href="#add-address" data-toggle="modal">
                        <svg width="38" height="48" viewBox="0 0 38 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M34.6263 47.9996L31.2837 37.3433H21.5078L18.999 41.2204L16.4901 37.3433H6.71424L3.37158 47.9996L3.37177 47.9998H34.6262L34.6263 47.9996Z" fill="#F2F2F2"></path>
                            <path d="M31.9673 5.36072C28.5273 1.92384 23.9494 0.0201562 19.0767 9.375e-05C19.051 9.375e-05 19.0253 0 18.9995 0C14.1197 0 9.52765 1.89825 6.06162 5.35012C2.60037 8.79712 0.694242 13.3686 0.694336 18.2223C0.69443 26.0495 5.69665 32.9891 13.1418 35.4908C13.9935 35.7771 14.7248 36.3398 15.2008 37.0756L18.2126 41.7298C18.3853 41.9968 18.6816 42.158 18.9997 42.158C19.3177 42.158 19.614 41.9968 19.7867 41.7298L22.7979 37.0765C23.2736 36.3414 24.0115 35.7761 24.8757 35.4847C32.31 32.978 37.3049 26.0407 37.3049 18.2221C37.305 13.3673 35.4093 8.79975 31.9673 5.36072ZM24.2766 33.7081C23.0128 34.1342 21.9286 34.9688 21.2237 36.0579L18.9997 39.4949L16.775 36.0571C16.0694 34.9667 14.9912 34.1344 13.739 33.7136C7.05818 31.4687 2.56934 25.2432 2.56924 18.2224C2.56915 13.871 4.27934 9.77137 7.38462 6.67875C10.4969 3.57919 14.619 1.875 18.9998 1.875C19.0227 1.875 19.0463 1.875 19.0691 1.87509C28.0905 1.91212 35.43 9.24534 35.43 18.2221C35.43 25.2352 30.9478 31.4587 24.2766 33.7081Z" fill="#D1362A"></path>
                            <g clip-path="url(#clip0)">
                                <path d="M26.2 17.2H19.8V10.8C19.8 10.3584 19.4416 10 19 10C18.5584 10 18.2 10.3584 18.2 10.8V17.2H11.8C11.3584 17.2 11 17.5584 11 18C11 18.4416 11.3584 18.8 11.8 18.8H18.2V25.2C18.2 25.6416 18.5584 26 19 26C19.4416 26 19.8 25.6416 19.8 25.2V18.8H26.2C26.6416 18.8 27 18.4416 27 18C27 17.5584 26.6416 17.2 26.2 17.2Z" fill="#D1362A"></path>
                            </g>
                        </svg>
                        <h4 class="title">إضافة عنوان جديد</h4></a></div>
            </div>
        </div>
    </form>
</div>

@include('layouts.partials.website.include._add_address')

@extends('layouts.website', ['headerClass' => 'header-inner', 'activeRoute' => ''])
@section('content')
    <section class="shopping-basket">
        <div class="container">
            <ul class="wizard">
                <li> <a href="{{route('website.home')}}">
                        الرئيسيه
                        <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                        </svg></a></li>
                <li> <a href="{{route('website.my-cart')}}">
                        سلة التسوق
                        <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                        </svg></a></li>
                <li>الدفع</li>
            </ul>
            <h2 class="title">الدفع</h2>
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
                        <div class="paying">
                            <h3 class="title">العنوان</h3>
                            <div class="paying-inner">
                                <label class="che-box bo-no">
                                    <input type="radio" name="addras">
                                    <h4 class="label-text">توصيل إلي عنواني مباشرة</h4>
                                    <div class="row">
{{--                                        <div class="col-sm-4 add-address"><a class="add" href="#add-address" data-toggle="modal"><img src="images/gps.svg" alt="" title="">--}}
{{--                                                <h4 class="title">توصيل للموقع الحالي</h4></a></div>--}}
                                        @foreach(auth()->user()->addresses()->with('location.parent')->get() as $address)
                                            <livewire:card.address-card
                                                :city="$address->location->parent->name"
                                                :district="$address->location->name"
                                                :fullAddress="$address->address_1"
                                                :addressId="$address->id"
                                                key="'address-card-in-my-cart'.$address->id"
                                            />
                                        @endforeach
                                        <div class="col-sm-4 add-address"><a class="add" href="#add-address" data-toggle="modal">
                                                <svg width="38" height="48" viewBox="0 0 38 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M34.6263 47.9996L31.2837 37.3433H21.5078L18.999 41.2204L16.4901 37.3433H6.71424L3.37158 47.9996L3.37177 47.9998H34.6262L34.6263 47.9996Z" fill="#F2F2F2"></path>
                                                    <path d="M31.9673 5.36072C28.5273 1.92384 23.9494 0.0201562 19.0767 9.375e-05C19.051 9.375e-05 19.0253 0 18.9995 0C14.1197 0 9.52765 1.89825 6.06162 5.35012C2.60037 8.79712 0.694242 13.3686 0.694336 18.2223C0.69443 26.0495 5.69665 32.9891 13.1418 35.4908C13.9935 35.7771 14.7248 36.3398 15.2008 37.0756L18.2126 41.7298C18.3853 41.9968 18.6816 42.158 18.9997 42.158C19.3177 42.158 19.614 41.9968 19.7867 41.7298L22.7979 37.0765C23.2736 36.3414 24.0115 35.7761 24.8757 35.4847C32.31 32.978 37.3049 26.0407 37.3049 18.2221C37.305 13.3673 35.4093 8.79975 31.9673 5.36072ZM24.2766 33.7081C23.0128 34.1342 21.9286 34.9688 21.2237 36.0579L18.9997 39.4949L16.775 36.0571C16.0694 34.9667 14.9912 34.1344 13.739 33.7136C7.05818 31.4687 2.56934 25.2432 2.56924 18.2224C2.56915 13.871 4.27934 9.77137 7.38462 6.67875C10.4969 3.57919 14.619 1.875 18.9998 1.875C19.0227 1.875 19.0463 1.875 19.0691 1.87509C28.0905 1.91212 35.43 9.24534 35.43 18.2221C35.43 25.2352 30.9478 31.4587 24.2766 33.7081Z" fill="#D1362A"></path>
                                                    <g clip-path="url(#clip0)">
                                                        <path d="M26.2 17.2H19.8V10.8C19.8 10.3584 19.4416 10 19 10C18.5584 10 18.2 10.3584 18.2 10.8V17.2H11.8C11.3584 17.2 11 17.5584 11 18C11 18.4416 11.3584 18.8 11.8 18.8H18.2V25.2C18.2 25.6416 18.5584 26 19 26C19.4416 26 19.8 25.6416 19.8 25.2V18.8H26.2C26.6416 18.8 27 18.4416 27 18C27 17.5584 26.6416 17.2 26.2 17.2Z" fill="#D1362A"></path>
                                                    </g>
                                                </svg>
                                                <h4 class="title">إضافة عنوان جديد</h4></a></div>
                                    </div>
                                </label>
                                <label class="che-box addborde">
                                    <input type="radio" name="addras">
                                    <h4 class="label-text">إستلام من الفرع  <span>فرع عابر القارات</span></h4>
                                </label>
                            </div>
                        </div>
                        <div class="paying">
                            <h3 class="title">الدفع</h3>
                            <div class="paying-inner">
                                <label class="che-box m-cash">
                                    <input type="radio" name="radio">
                                    <h4 class="label-text">الدفع عند الإستلام   <span>الدفع كاش عند الإستلام</span></h4>
                                </label>
                                <label class="che-box m-bank">
                                    <input type="radio" name="radio"><span class="label-text">الدفع بإستخدام بطاقة الائتمان وبطاقات مدى</span>
                                </label>
                                <div class="hidebank">
                                    <div class="items-img"><img src="images/ba-1.png" alt="" title=""><img src="images/ba-2.png" alt="" title=""><img src="images/ba-3.png" alt="" title=""></div>
                                    <div class="row">
                                        <div class="col-sm-6 field">
                                            <label>إسم حامل البطاقه*</label>
                                            <input class="form-control" type="text" placeholder="الإسم علي البطاقه*" value="">
                                        </div>
                                        <div class="col-sm-6 field">
                                            <label>رقم البطاقة*</label>
                                            <input class="form-control" type="text" placeholder="رقم البطاقة*" value="">
                                        </div>
                                        <div class="col-sm-12 field">
                                            <label>تاريخ إنتهاء البطاقة*</label>
                                            <div class="row">
                                                <div class="col itemselect">
                                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0)">
                                                            <path d="M3.78049 6.06472L0.0864105 2.37063C-0.0316992 2.24834 -0.0283081 2.05346 0.0939863 1.93535C0.213286 1.82013 0.40241 1.82013 0.521692 1.93535L3.99814 5.41179L7.47458 1.93535C7.59478 1.81517 7.78966 1.81517 7.90986 1.93535C8.03005 2.05557 8.03005 2.25043 7.90986 2.37063L4.21578 6.06472C4.09556 6.1849 3.9007 6.1849 3.78049 6.06472Z" fill="#252525"></path>
                                                        </g>
                                                    </svg>
                                                    <select class="form-control">
                                                        <option>إختر الشهر</option>
                                                        <option>فبراير</option>
                                                    </select>
                                                </div>
                                                <div class="col itemselect">
                                                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0)">
                                                            <path d="M3.78049 6.06472L0.0864105 2.37063C-0.0316992 2.24834 -0.0283081 2.05346 0.0939863 1.93535C0.213286 1.82013 0.40241 1.82013 0.521692 1.93535L3.99814 5.41179L7.47458 1.93535C7.59478 1.81517 7.78966 1.81517 7.90986 1.93535C8.03005 2.05557 8.03005 2.25043 7.90986 2.37063L4.21578 6.06472C4.09556 6.1849 3.9007 6.1849 3.78049 6.06472Z" fill="#252525"></path>
                                                        </g>
                                                    </svg>
                                                    <select class="form-control">
                                                        <option>إختر السنة</option>
                                                        <option>2021</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 field">
                                            <label>رمز أمان البطاقة</label>
                                            <input class="form-control" type="text" placeholder="CVV" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <livewire:price-card key="'price-card-in-finish-order'" :finishOrder="'true'"/>
                </div>
            </form>
        </div>
    </section>
   @include('layouts.partials.website.include._add_address')
    <div class="modal fade" id="completion" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content login">
                <div class="headtitle">
                    <h3 class="title">تأكيد عملية الشراء</h3>
                    <button class="close" type="button" data-dismiss="modal">
                        <svg width="8" height="8" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.66271 6.00002L11.8625 0.800231C12.0455 0.617161 12.0455 0.320349 11.8625 0.137303C11.6794 -0.0457441 11.3826 -0.0457675 11.1995 0.137303L5.99975 5.33709L0.799987 0.137303C0.616917 -0.0457675 0.320105 -0.0457675 0.137058 0.137303C-0.0459882 0.320373 -0.0460117 0.617185 0.137058 0.800231L5.33682 6L0.137058 11.1998C-0.0460117 11.3829 -0.0460117 11.6797 0.137058 11.8627C0.228582 11.9542 0.348558 12 0.468535 12C0.588511 12 0.708464 11.9542 0.800011 11.8627L5.99975 6.66295L11.1995 11.8627C11.291 11.9542 11.411 12 11.531 12C11.651 12 11.7709 11.9542 11.8625 11.8627C12.0455 11.6796 12.0455 11.3828 11.8625 11.1998L6.66271 6.00002Z" fill="#1A1919"></path>
                        </svg>
                    </button>
                </div>
                <p class="text" id="completionMessage"></p>
                <div class="field"><a class="bottom" href="#"  id="finishOrder">
                        <svg width="24" height="24" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.7922 4.06045C13.6073 3.82852 13.3299 3.69547 13.0312 3.69547H10.335L8.87294 0.347692C8.78229 0.140125 8.54052 0.0452699 8.33293 0.135969C8.12533 0.226614 8.03053 0.468415 8.1212 0.676008L9.43986 3.6955H4.56015L5.8788 0.676008C5.96944 0.468415 5.87467 0.226641 5.66708 0.135969C5.45951 0.0452699 5.21771 0.140071 5.12706 0.347692L3.66502 3.6955H0.968818C0.67006 3.6955 0.392713 3.82852 0.207842 4.06048C0.0263611 4.2882 -0.0406037 4.58094 0.0241189 4.86373L1.46396 11.1528C1.5645 11.5919 1.95297 11.8986 2.40866 11.8986H11.5913C12.047 11.8986 12.4355 11.5919 12.536 11.1528L13.9759 4.8637C14.0406 4.58091 13.9736 4.28817 13.7922 4.06045ZM11.5913 11.0783H2.40866C2.33901 11.0783 2.27801 11.0326 2.2636 10.9697L0.823759 4.68066C0.812467 4.63131 0.831416 4.59418 0.849353 4.57173C0.865978 4.55084 0.903631 4.51581 0.968818 4.51581H3.30679L3.19936 4.76182C3.10871 4.96941 3.20349 5.21119 3.41108 5.30186C3.46451 5.32521 3.52018 5.33626 3.57501 5.33626C3.73311 5.33626 3.88377 5.2443 3.95109 5.09017L4.20192 4.51586H9.79814L10.049 5.09017C10.1163 5.24433 10.267 5.33626 10.4251 5.33626C10.4798 5.33626 10.5355 5.32521 10.589 5.30186C10.7966 5.21122 10.8914 4.96941 10.8007 4.76182L10.6933 4.51581H13.0312C13.0964 4.51581 13.1341 4.55084 13.1507 4.57173C13.1686 4.5942 13.1876 4.63134 13.1763 4.68064L11.7365 10.9697C11.722 11.0326 11.661 11.0783 11.5913 11.0783Z" fill="#fff"></path>
                            <path d="M4.53906 6.29297C4.31255 6.29297 4.12891 6.47661 4.12891 6.70313V9.71094C4.12891 9.93745 4.31255 10.1211 4.53906 10.1211C4.76558 10.1211 4.94922 9.93745 4.94922 9.71094V6.70313C4.94922 6.47661 4.76561 6.29297 4.53906 6.29297Z" fill="#fff"></path>
                            <path d="M7 6.29297C6.77348 6.29297 6.58984 6.47661 6.58984 6.70313V9.71094C6.58984 9.93745 6.77348 10.1211 7 10.1211C7.22652 10.1211 7.41016 9.93745 7.41016 9.71094V6.70313C7.41016 6.47661 7.22652 6.29297 7 6.29297Z" fill="#fff"></path>
                            <path d="M9.46094 6.29297C9.23442 6.29297 9.05078 6.47661 9.05078 6.70313V9.71094C9.05078 9.93745 9.23442 10.1211 9.46094 10.1211C9.68745 10.1211 9.87109 9.93745 9.87109 9.71094V6.70313C9.87107 6.47661 9.68745 6.29297 9.46094 6.29297Z" fill="#fff"></path>
                        </svg>إتمام عمليه الشراء</a></div>
            </div>
        </div>
    </div>
    <livewire:delete-address key="'delete-address'" />
{{--    <div class="modal fade" id="delete" role="dialog">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content login">--}}
{{--                <div class="headtitle">--}}
{{--                    <h3 class="title">ازالة العنوان</h3>--}}
{{--                    <button class="close" type="button" data-dismiss="modal">--}}
{{--                        <svg width="8" height="8" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                            <path d="M6.66271 6.00002L11.8625 0.800231C12.0455 0.617161 12.0455 0.320349 11.8625 0.137303C11.6794 -0.0457441 11.3826 -0.0457675 11.1995 0.137303L5.99975 5.33709L0.799987 0.137303C0.616917 -0.0457675 0.320105 -0.0457675 0.137058 0.137303C-0.0459882 0.320373 -0.0460117 0.617185 0.137058 0.800231L5.33682 6L0.137058 11.1998C-0.0460117 11.3829 -0.0460117 11.6797 0.137058 11.8627C0.228582 11.9542 0.348558 12 0.468535 12C0.588511 12 0.708464 11.9542 0.800011 11.8627L5.99975 6.66295L11.1995 11.8627C11.291 11.9542 11.411 12 11.531 12C11.651 12 11.7709 11.9542 11.8625 11.8627C12.0455 11.6796 12.0455 11.3828 11.8625 11.1998L6.66271 6.00002Z" fill="#1A1919"></path>--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <p class="text"> هل انت متأكد من حذف العنوان</p>--}}
{{--                <div class="field"><a class="bottom" href="#">نعم بالتأكيد</a></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
@push('scripts')

    <script>
        $("#completionButton").click(function (){
            $("#completionMessage").empty()
            $("#completionMessage").append(`
            يرجي التأكيد، بأن طلبك من <span>فرع عابر  القارات</span> علي عنوان <span>جدة، الحي الأول، عمارة رقم ٣</span>
            `)
        })
    </script>
    <script>
        $("#errorContainerLogin").hide()
        $("#finishOrder").click(function (event){
            event.preventDefault();
            let products = {!! \App\Common\Facades\Cart::getProductsToBeOrdered()!!};
            let address_id = $('input[name="address_id"]:checked').val();
            let branch_id = {!! \App\Common\Facades\Branch::get()->id !!};
            let user_id = {!! auth()->id() !!};
            let discount_id =' {!! \App\Common\Facades\Cart::getCouponId() !!}';
            let subtotal = {!! \App\Common\Facades\Cart::getTotalPrice() !!};
            let _token   = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{!! route('orders.store') !!}",
                type:"POST",
                data:{
                    products:products,
                    address_id:address_id,
                    discount_id:discount_id,
                    branch_id:branch_id,
                    subtotal:subtotal,
                    user_id:user_id,
                    _token:_token
                },
                success:function(response){
                    window.location.replace("{!! route('website.home') !!}")
                },
                error:function (response){
                    $("#loginErrors").empty();
                    $("#errorContainerLogin").show();
                    $.each(response.responseJSON.errors, function (key, item)
                    {
                        console.log(item)
                        $("#loginErrors").append("<li class='text-light m-2 font-weight-bold'>"+item+"</li>")
                    });
                }
            });
        })
        $("#completion").click(function (){

        })
    </script>
    @endPush

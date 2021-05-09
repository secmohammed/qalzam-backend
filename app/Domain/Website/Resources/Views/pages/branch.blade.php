@extends('layouts.website', ['headerClass' => 'header-inner', 'activeRoute' => 'branches'])
@section('content')
<section class="list">
    <div class="container">
        <ul class="wizard">
            <li> <a href="{{route('website.home')}}">
                    الرئيسيه
                    <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                    </svg></a></li>
            <li> القائمة </li>
        </ul>
        <h2 class="title">قائمه القلزم <span>68 نتيجه</span></h2>
        <nav class="list-filter"><a class="active" href="#">جميع المنتجات</a><a href="#">الاسماك</a><a href="#">ثمار البحر</a><a href="#">كوزي القلزم المميز</a><a href="#">الأطباق الرئيسية</a><a href="#">الشوربات</a></nav>
        <div class="listicons">
            <nav class="tags"> <a href="#">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 11.2H2L6.5 16V0H5V11.2ZM9.5 2.4V16H11V4.8H14L9.5 0V2.4Z" fill="#D1362A"></path>
                    </svg>ترتيب بواسطه</a></nav>
            <ul class="gred-icons">
                <li class="grad-row">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="12" height="2.76922"></rect>
                        <rect y="4.6153" width="12" height="2.76928"></rect>
                        <rect y="9.23071" width="12" height="2.76922"></rect>
                    </svg>
                </li>
                <li class="grad-col active">
                    <svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                        <rect width="2.76929" height="2.76922"></rect>
                        <rect width="2.76929" height="2.76922"></rect>
                        <rect x="4.61536" width="2.76929" height="2.76922"></rect>
                        <rect x="9.23071" width="2.76929" height="2.76922"></rect>
                        <rect y="4.6153" width="2.76929" height="2.76928"></rect>
                        <rect x="4.61523" y="4.6153" width="2.76929" height="2.76928"></rect>
                        <rect x="9.23047" y="4.6153" width="2.76929" height="2.76928"></rect>
                        <rect y="9.23071" width="2.76929" height="2.76922"></rect>
                        <rect x="4.61523" y="9.23071" width="2.76929" height="2.76922"></rect>
                        <rect x="9.23047" y="9.23071" width="2.76929" height="2.76922"></rect>
                    </svg>
                </li>
            </ul>
        </div>
        <div class="most-wanted">
            <div class="row">
                <livewire:branch-products
                    :action="'add-to-cart'"
                    :pagination="'true'"
                    :branchId="$branch->id"
                />
            </div>
        </div>
    </div>
</section>
<section class="best-seller bg-seller">
    <div class="container">
        <div class="head-title">
            <h2 class="title">الأكثر مبيعاً</h2>
        </div>
        <div class="seller-slider">
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
            <div class="item"><a href="list-details.html">
                    <div class="photo"><img src="images/slider/img-1.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title">طاجن ثمار<br/>البحر</h2>
                        <p class="price">80 ريال</p>
                    </div></a></div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        Livewire.on('canNotBeAdd', product => {
            alert('THis Can not Be Added' + product.totalPrice)
        })
    </script>
@endpush
@endsection

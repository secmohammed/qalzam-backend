@extends('layouts.website', ['headerClass' => 'header-inner', 'activeRoute' => ''])
@section('content')
<section class="list">
    <div class="container">
        <ul class="wizard">
            <li> <a href="{{route('website.home')}}">
                    الرئيسيه
                    <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                    </svg></a></li>
            <li> <a href="{{route('website.branch',$branch->id)}}">
                    {{ $branch->name }}
                    <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                    </svg></a></li>
            <li> {{ $product->name }} </li>
        </ul>
      
              <div class="row">
                <div class="col-sm-5 item-inner">
                  <div class="carousel slide carousel-fade" id="carouselExampleIndicators" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active"><img src="{{ asset("media/slider/img-1.jpg") }}" alt=""></div>
                      <div class="carousel-item">       <img src="{{ asset("media/slider/img-2.jpg") }}" alt=""></div>
                      <div class="carousel-item">       <img src="{{ asset("media/slider/img-3.jpg") }}" alt="">     </div>
                      <div class="carousel-item">       <img src="{{ asset("media/slider/img-4.jpg") }}" alt=""></div>
                    </div>
                    <ol class="carousel-indicators">
                      <li class="active" data-target="#carouselExampleIndicators" data-slide-to="0"><img src="{{ asset("media/slider/img-1.jpg") }}" alt=""></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="1"><img src="{{ asset("media/slider/img-2.jpg") }}" alt=""></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="2"><img src="{{ asset("media/slider/img-3.jpg") }}" alt=""></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="3"><img src="{{ asset("media/slider/img-4.jpg") }}" alt=""></li>
                    </ol>
                  </div>
                </div>
                <div class="col-sm-7 item-inner">
                  <h2 class="title">{{ $product->name }} </h2>
                  <p class="text">{{ $product->desicription }}</p>
                  <div class="listorder">
                    <h3 class="title">{{ $product->name }} </h3>
                    <nav class="list-filter"><a class="active" href="#">فرن</a><a href="#">مشوي</a><a href="#">مقلي</a><a href="#">نيئ</a></nav>
                    <p class="text">يحتوي علي ١٥٠٠ سعر حراري</p>
                  </div>
                  <p class="price">{{ $product->price->formatted() }} </p>
                  <div class="ac-bot">
                    <form class="spinner" action="#" method="">
                      <button class="btn btn-default ault" type="button">
                        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M8.88413 5.16H5.79613V8.344H4.00413V5.16H0.948125V3.64H4.00413V0.44H5.79613V3.64H8.88413V5.16Z" fill="#707070"></path>
                        </svg>
                      </button>
                      <input class="form-control" type="text" value="1">
                      <button class="btn btn-default" type="button">
                        <svg width="5" height="3" viewBox="0 0 5 3" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M4.87425 2.32H0.02625V0.72H4.87425V2.32Z" fill="#707070"></path>
                        </svg>
                      </button>
                    </form><a class="addcard" href="mycard.html">
                      <svg width="24" height="24" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.7922 4.06045C13.6073 3.82852 13.3299 3.69547 13.0312 3.69547H10.335L8.87294 0.347692C8.78229 0.140125 8.54052 0.0452699 8.33293 0.135969C8.12533 0.226614 8.03053 0.468415 8.1212 0.676008L9.43986 3.6955H4.56015L5.8788 0.676008C5.96944 0.468415 5.87467 0.226641 5.66708 0.135969C5.45951 0.0452699 5.21771 0.140071 5.12706 0.347692L3.66502 3.6955H0.968818C0.67006 3.6955 0.392713 3.82852 0.207842 4.06048C0.0263611 4.2882 -0.0406037 4.58094 0.0241189 4.86373L1.46396 11.1528C1.5645 11.5919 1.95297 11.8986 2.40866 11.8986H11.5913C12.047 11.8986 12.4355 11.5919 12.536 11.1528L13.9759 4.8637C14.0406 4.58091 13.9736 4.28817 13.7922 4.06045ZM11.5913 11.0783H2.40866C2.33901 11.0783 2.27801 11.0326 2.2636 10.9697L0.823759 4.68066C0.812467 4.63131 0.831416 4.59418 0.849353 4.57173C0.865978 4.55084 0.903631 4.51581 0.968818 4.51581H3.30679L3.19936 4.76182C3.10871 4.96941 3.20349 5.21119 3.41108 5.30186C3.46451 5.32521 3.52018 5.33626 3.57501 5.33626C3.73311 5.33626 3.88377 5.2443 3.95109 5.09017L4.20192 4.51586H9.79814L10.049 5.09017C10.1163 5.24433 10.267 5.33626 10.4251 5.33626C10.4798 5.33626 10.5355 5.32521 10.589 5.30186C10.7966 5.21122 10.8914 4.96941 10.8007 4.76182L10.6933 4.51581H13.0312C13.0964 4.51581 13.1341 4.55084 13.1507 4.57173C13.1686 4.5942 13.1876 4.63134 13.1763 4.68064L11.7365 10.9697C11.722 11.0326 11.661 11.0783 11.5913 11.0783Z" fill="#fff"></path>
                        <path d="M4.53906 6.29297C4.31255 6.29297 4.12891 6.47661 4.12891 6.70313V9.71094C4.12891 9.93745 4.31255 10.1211 4.53906 10.1211C4.76558 10.1211 4.94922 9.93745 4.94922 9.71094V6.70313C4.94922 6.47661 4.76561 6.29297 4.53906 6.29297Z" fill="#fff"></path>
                        <path d="M7 6.29297C6.77348 6.29297 6.58984 6.47661 6.58984 6.70313V9.71094C6.58984 9.93745 6.77348 10.1211 7 10.1211C7.22652 10.1211 7.41016 9.93745 7.41016 9.71094V6.70313C7.41016 6.47661 7.22652 6.29297 7 6.29297Z" fill="#fff"></path>
                        <path d="M9.46094 6.29297C9.23442 6.29297 9.05078 6.47661 9.05078 6.70313V9.71094C9.05078 9.93745 9.23442 10.1211 9.46094 10.1211C9.68745 10.1211 9.87109 9.93745 9.87109 9.71094V6.70313C9.87107 6.47661 9.68745 6.29297 9.46094 6.29297Z" fill="#fff"></path>
                      </svg>إضافه إلي السله</a>
                      
                      <livewire:wishlist.add-wishlist
                      :product="$product"

                  />
                  </div>
                </div>
              </div>
            </div>
          </section>


@endsection

@push('scripts')
<script>
       Livewire.emit('toggleWishlist')

</script>
@endpush
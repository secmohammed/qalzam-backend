@extends('layouts.website', ['headerClass' => 'header-inner', 'activeRoute' => ''])
@section('content')
    <section class="branches">
        <div id="map"></div>
        <div class="container">
            <ul class="wizard">
                <li>
                    <a href="{{route('website.home')}}">
                        الرئيسيه
                        <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                        </svg>
                    </a>
                </li>
                <li> فروعنا</li>
            </ul>
            <h2 class="title">فروعنا</h2>
            <div class="row">
                <div class="col-sm-5 item">
                    <div class="con-item">
                        <h4 class="title">منتجع القلزم</h4>
                        <p class="text">جدة - طريق المدينة - امام مقر وزارة الداخلية</p>
                        <nav class="con-item"><a href="#"><img src="{{asset('assets/website/images/telephone.svg')}}" alt="" title=""> 920001515</a><a href="#"><img src="{{asset('assets/website/images/mail-outline.svg')}}" alt="" title=""> info@qalzam.com</a></nav>
                    </div>
                    <div class="con-item">
                        <h4 class="title">فرع عابر القارات</h4>
                        <p class="text">جدة - طريق عابر القارات-ابحر الشمالية</p>
                        <nav class="con-item"><a href="#"><img src="{{asset('assets/website/images/telephone.svg')}}" alt="" title=""> 920001515</a><a href="#"><img src="{{asset('assets/website/images/mail-outline.svg')}}" alt="" title=""> info@qalzam.com</a></nav>
                    </div>
                    <div class="con-item">
                        <h4 class="title">فرع شرم ابحر</h4>
                        <p class="text">جدة - طريق الكورنيش-ابحر الجنوبية</p>
                        <nav class="con-item"><a href="#"><img src="{{asset('assets/website/images/telephone.svg')}}" alt="" title=""> 920001515</a><a href="#"><img src="{{asset('assets/website/images/mail-outline.svg')}}" alt="" title=""> info@qalzam.com</a></nav>
                    </div>
                    <div class="con-item">
                        <h4 class="title">فرع الامير سلطان</h4>
                        <p class="text">جدة - طريق الامير سلطان</p>
                        <nav class="con-item"><a href="#"><img src="{{asset('assets/website/images/telephone.svg')}}" alt="" title=""> 920001515</a><a href="#"><img src="{{asset('assets/website/images/mail-outline.svg')}}" alt="" title=""> info@qalzam.com</a></nav>
                    </div>
                    <div class="con-item">
                        <h4 class="title">مدينة العاب ايفنت مول</h4>
                        <p class="text">طريق جدة مكة السريع</p>
                        <nav class="con-item"><a href="#"><img src="{{asset('assets/website/images/telephone.svg')}}" alt="" title=""> 920001515</a><a href="#"><img src="{{asset('assets/website/images/mail-outline.svg')}}" alt="" title=""> info@qalzam.com</a></nav>
                    </div>
                    <div class="con-item">
                        <h4 class="title">مدينة العاب قلزومي فن سيتي</h4>
                        <p class="text">جدة - طريق المدينة - امام مقر وزارة الداخلية</p>
                        <nav class="con-item"><a href="#"><img src="{{asset('assets/website/images/telephone.svg')}}" alt="" title=""> 920001515</a><a href="#"><img src="{{asset('assets/website/images/mail-outline.svg')}}" alt="" title=""> info@qalzam.com</a></nav>
                    </div>
                    <div class="con-item">
                        <h4 class="title">فرع انس بن مالك</h4>
                        <p class="text">الرياض - طريق انس بن ماك - حي الملقا</p>
                    </div>
                    <div class="con-item">
                        <h4 class="title">فرع العليا</h4>
                        <p class="text">الرياض - تقاطع شارع التخصصي مع العروبة - حي العليا</p>
                        <nav class="con-item"><a href="#"><img src="{{asset('assets/website/images/telephone.svg')}}" alt="" title=""> 920001515</a><a href="#"><img src="{{asset('assets/website/images/mail-outline.svg')}}" alt="" title=""> info@qalzam.com</a></nav>
                    </div>
                </div>
            </div>
        </div>
    @push('scripts')
    @endpush
@endsection

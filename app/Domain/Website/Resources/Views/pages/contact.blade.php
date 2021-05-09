@extends('layouts.website', ['activeRoute' => '','headerClass' => 'header-inner'])
@section('content')
<section class="contact">
    <div id="map"></div>
    <div class="container">
        <ul class="wizard">
            <li> <a href="index.html">
                    الرئيسيه
                    <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                    </svg></a></li>
            <li> تواصل معانا</li>
        </ul>
        <h2 class="title">تواصل معنا</h2>
        <div class="row">
            <div class="col-sm-5 item">
                <h3 class="inquiry">عزيزنا العميل لا تتردد<br/> في الاتصال للاستفسار عن أي طلب أو معلومة قد تحتاج اليها </h3>
                <div class="con-item">
                    <h4 class="text">الرقم الموحد</h4>
                    <p class="title">920001515</p>
                </div>
                <div class="con-item">
                    <h4 class="text">العنوان</h4>
                    <p class="title">المركز الرئيسي-حدة طريق المدينة امام مقر وزارة الداخلية قبل كوبرى ذهبان</p>
                </div>
                <div class="con-item">
                    <h4 class="text">الرمز البريدى</h4>
                    <p class="title"> 23872-2383 رقم المبنى 6859</p>
                </div>
                <div class="con-item">
                    <h4 class="text">العنوان الإلكتروني</h4><a class="title" href="mailTo:INFO@ALQALZAM.COM">INFO@ALQALZAM.COM</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

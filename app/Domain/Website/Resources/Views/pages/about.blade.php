@extends('layouts.website' , ['activeRoute' => '' ,'headerClass' => 'header-inner'])
@section('content')
<section class="aboutus">
    <div class="container">
        <ul class="wizard">
            <li> <a href="{{route('website.home')}}">
                {{__('website.main')}}
                    <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                    </svg></a></li>
            <li>{{__('website.about.about-us')}} </li>
        </ul>
        <h2 class="title">{{__('website.about.about-qalzam')}}</h2>
        <div class="content">
            <h3 class="title">{{__('website.about.about-us')}}</h3>
            <p class="text">{{__('website.about.desc-1')}}</p>
            <div class="row">
                <div class="col-sm-4 item">
                    <div class="inner">
                        <h4 class="title">{{__('website.about.our-message')}}</h4>
                        <p class="text">{{__('website.about.desc-2')}}</p>
                    </div>
                </div>
                <div class="col-sm-4 item">
                    <div class="inner">
                        <h4 class="title">{{__('website.about.goals')}}</h4>
                        <p class="text">{{__('website.about.desc-3')}}</p>
                    </div>
                </div>
                <div class="col-sm-4 item">
                    <div class="inner">
                        <h4 class="title">{{__('website.about.vision')}}</h4>
                        <p class="text">{{__('website.about.desc-4')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="min-video">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 item">
                <h2 class="title">{{__('website.about.video.title-1')}}<br/>{{__('website.about.video.title-2')}}</h2>
                <p>{{__('website.about.video.desc-1')}}</p>
            </div><a class="bla-2 cd-single-point" href="https://youtu.be/8-0CjqUhvsk"> <i class="cd-img-replace"> </i><i class="innerbc">
                    <svg width="23" height="29" viewBox="0 0 23 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.835352 0.998526C0.479041 1.20118 0.258911 1.57953 0.258911 1.98921V26.9983C0.258911 27.6277 0.769257 28.1379 1.3985 28.1379C2.02774 28.1379 2.53809 27.6277 2.53809 26.9983V3.99394L19.4103 14.0381L7.00319 22.0317C6.47423 22.3727 6.32152 23.0779 6.66245 23.6069C7.00356 24.136 7.70859 24.2887 8.23774 23.9476L22.191 14.9576C22.5227 14.7439 22.7202 14.3739 22.7132 13.9794C22.7061 13.5849 22.4957 13.2221 22.1567 13.0203L1.9814 1.00992C1.62889 0.800427 1.19166 0.795869 0.835352 0.998526Z" fill="#D1362A"></path>
                    </svg></i></a>
        </div>
    </div>
</section>
<!--End minvideo-->
@endsection

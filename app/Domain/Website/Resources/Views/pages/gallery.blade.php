@extends('layouts.website', ['activeRoute' => '', 'headerClass' => 'header-inner'])
@section('content')
    <section class="gallary">
        <div class="container">
            <ul class="wizard">
                <li> <a href="{{route('website.home')}}">
                    {{__('website.main')}}
                        <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                        </svg></a></li>
                <li> <a href="{{route('website.galleries')}}">
                        {{__('website.photo-gallery')}}
                        <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                        </svg></a></li>
                <li>{{__('website.resort')}}</li>
            </ul>
            <h2 class="title">{{__('website.resort')}}</h2>
            <div class="row">
                @foreach($album->getMediaCollectionUrl('album-gallery') as $url)
                    <div class="col-sm-4 photo-gall"> <a class="elem" href="{{$url}}" title="" data-lcl-txt="" data-lcl-author="" data-lcl-thumb="{{$url}}"><span style="background-image: url('{{$url}}');"></span></a></div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

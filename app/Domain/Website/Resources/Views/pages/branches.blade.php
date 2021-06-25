@extends('layouts.website', ['headerClass' => 'header-inner', 'activeRoute' => 'branches'])
@section('content')
<section class="list">
    <div class="container">
        <ul class="wizard">
            <li> <a href="{{route('website.home')}}">
                {{__('website.main')}}
                    <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                    </svg></a></li>
            <li> {{__('website.branches')}} </li>
        </ul>
        <h2 class="title">{{__('website.branches-list')}}</h2>
        <div class="row">
            @foreach($branches as $branch)
                <div class="col-sm-3 item-bra ">
                    <a class="photo {{$branch->isClosed ? ' unavailable' :''}}" href="{{!$branch->isClosed  ? route('website.branch', ['branch' => $branch]) : '#'}}">
                    <img src="{{$branch->getLastMediaUrl('branch-gallery')}}" alt="" title="">
                        <div class="content">
                            <div class="d-flex flex-column">

                                <h3 class="title " >{{$branch->preview_name}}</h3>
                                <h3 class="title " >{{$branch->isClosed ?__('main.closed'):""}}</h3>
                                <p style="display:{{$branch->isClosed ?'none':'block'}}" class="text font-weight-bold mt-2 "> {{$branch->is_available_receipt === "active" ? __('main.is_available_receipt'):"" }}</p>
                                <p style="display:  {{$branch->isClosed ?'none':'block'}}  " class="text font-weight-bold " > {{$branch->is_available_delivery === "active" ? __('main.is_available_delivery'):""}}</p>
                                </div>

                                    {{-- <div class=" mt-3 " style="margin-right: 58px"> --}}
        
                            {{-- </div> --}}
                        </div>
                   
               
                    </a>
                   

                    
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

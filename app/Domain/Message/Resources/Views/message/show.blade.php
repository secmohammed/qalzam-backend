@extends('layouts.layout')
@push('styles')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.8.3/css/lg-fb-comment-box.min.css"
    integrity="sha512-vYu0Nd+ml6fhXHO671nhVS/c/puVD65iw4sJNw3j2zrH/q0i7pOIz9eoTZC3bxyRzYQfidejBbLcjJJMksYYpg=="
    crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.8.3/css/lg-transitions.min.css"
        integrity="sha512-/kdQdrZJ0rc181QhzXU6oIknhyr5NIuZlv4VzvhdDsiEzEbW9mckFGTqat8CM8FlGDCHMMUYity1gXIgjHJ58A=="
        crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.8.3/css/lightgallery.min.css"
            integrity="sha512-gk6oCFFexhboh5r/6fov3zqTCA2plJ+uIoUx941tQSFg6TNYahuvh1esZVV0kkK+i5Kl74jPmNJTTaHAovWIhw=="
            crossorigin="anonymous"/>
            @if(GetLanguage() == 'ar')
                <style>
                .lg-outer {
                direction: ltr;
                }
                </style>
            @endif
@endpush
@section('content')
<div class="subheader py-2 py-lg-6  subheader-transparent " id="kt_subheader">
    <div class="container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Mobile Toggle-->
            <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none"
            id="kt_subheader_mobile_toggle">
            <span></span>
            </button>
            <!--end::Mobile Toggle-->
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class=" text-dark font-weight-bold my-1 mr-5 {{ GetLanguage() == 'ar' ? 'ml-2' : '' }}">
                {{ __('main.show') }} {{ __('main.message') }} </h5>
                <!--end::Page Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}" class="text-muted">
                        {{ __('main.home') }} </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('messages.index') }}" class="text-muted">
                        {{ __('main.messages') }} </a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
    </div>
</div>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Todo-->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <h3 class="card-title">
                        {{ __('main.show') }} {{ __('main.message') }} : # {{ $show->id }}
                        </h3>
                        <div class="card-toolbar">
                            <a title="{{ __('main.create') }} {{ __('main.message') }}"
                                href="{{ route('messages.create') }}"
                                class="btn btn-light-primary font-weight-bolder mr-2">
                                <i class="flaticon2-plus"
                            style="color: #FFF"></i> {{ __("main.add") }} {{ __("main.message") }} </a>
                            <a title="{{ __('main.edit') }} {{ __('main.message') }}"
                                href="{{ route('messages.edit', $show->id) }}"
                                class="btn btn-light-warning font-weight-bolder mr-2">
                            <i class="flaticon2-edit"></i> {{ __("main.edit") }} {{ __("main.message") }} </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-5">
                                <div class="row mb-2">
                                    <strong class='ml-3'><span>{{ __("main.title") }} : </span></strong>
                                    <span>{{ $show->title ?? 'N/A' }} </span>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="row mb-2">
                                    <strong class='ml-3'><span>{{ __("main.body") }} : </span></strong>
                                    <span>{{ $show->body ?? 'N/A' }} </span>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="row mb-2">
                                    <strong class='ml-3'><span>{{ __("main.user") }} : </span></strong>
                                    <span>{{ $show->user->name }} </span>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="row mb-2">
                                    <strong class='ml-3'><span>{{ __("main.type") }} : </span></strong>
                                    <span>{{ $show->type ? __("main.{$show->type}") : 'N/A' }} </span>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="row mb-2">
                                    <strong class='ml-3'><span>{{ __("main.competition") }} : </span></strong>
                                    <span> Broadcasted to : {{ $show->competition ? $show->competition->name : 'All' }} </span>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="row mb-2">
                                    <strong class='ml-3'><span>{{ __("main.delay") }} : </span></strong>
                                    <span>{{$show->delay}}</span>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="row mb-2">
                                    <strong class='ml-3'><span>{{ __("main.created_at") }} : </span></strong>
                                    <span>{{$show->created_at}}</span>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.8.3/js/lightgallery.min.js"></script>
    <script>
        $(document).ready(function () {
        $("#lightgallery").lightGallery();
        });
    </script>
@endpush

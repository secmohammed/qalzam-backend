@extends('theme.app')

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

    <style>
        .lg-outer {
            direction: ltr;
        }
    </style>

@endpush

@section('content')

    <div class="subheader py-2 py-lg-6  subheader-transparent" id="kt_subheader">
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
                        {{ __('main.show') }} {{ __('main.branch') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-muted">
                                {{ __('main.home') }} </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('branch_shifts.index') }}" class="text-muted">
                                {{ __('main.branches') }} </a>
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
                                {{ __('main.show') }} {{ __('main.branch-shifts') }} : # {{ $branch_shift->id }}
                            </h3>
                            <div class="card-toolbar">
                                <a title="{{ __('main.create') }} {{ __('main.branch') }}"
                                   href="{{ route('branch_shifts.create') }}"
                                   class="btn btn-light-primary font-weight-bolder mr-2">
                                    <i class="flaticon2-plus"
                                       style="color: #FFF"></i> {{ __("main.add") }} {{ __("main.branch") }} </a>
                                <a title="{{ __('main.delete') }} {{ __('main.branch') }}"
                                   href="{{ route('branch_shifts.destroy', $branch_shift->id) }}"
                                   class="btn btn-light-danger font-weight-bolder mr-2" data-toggle="modal"
                                   data-target="#delete_{{$branch_shift->id}}">
                                    <i class="flaticon2-trash"></i> {{ __("main.delete") }} {{ __("main.branch") }}
                                </a>
                                <a title="{{ __('main.edit') }} {{ __('main.branch') }}"
                                   href="{{ route('branch_shifts.edit', $branch_shift->id) }}"
                                   class="btn btn-light-warning font-weight-bolder mr-2">
                                    <i class="flaticon2-edit"></i> {{ __("main.edit") }} {{ __("main.branch") }} </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class="ml-3"><span>{{ __("main.day") }} : </span></strong>
                                        <span>{{ $branch_shift->day ?? 'N/A' }} </span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.status") }} : </span></strong>
                                        <span >{{$branch_shift->status }}</span>
                                    </div>
                                    <hr>
                                </div>
                                
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.branch") }} : </span></strong>
                                        <span >{{$branch_shift->branch->name }}</span>
                                    </div>
                                    <hr>
                                </div>
                                
                                
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.start-time") }} : </span></strong>
                                        <span>{{$branch_shift->start_time}}</span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.end-time") }} : </span></strong>
                                        <span>{{$branch_shift->end_time }}</span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.created_at") }} : </span></strong>
                                        <span>{{$branch_shift->created_at}}</span>
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


    <div class="modal fade" id="delete_{{$branch_shift->id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('main.delete') }} {{ __('main.branch') }}
                        : {{ __('main.branches') }} #({{ $branch_shift->name }})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('branch_shifts.destroy', $branch_shift->id) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <div class="modal-body">
                        {{ __('main.delete') }} {{ __('main.branches') }}: {{ __('main.branches') }}
                        #({{ $branch_shift->name }})
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('main.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('main.delete') }}</button>
                    </div>
                </form>
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
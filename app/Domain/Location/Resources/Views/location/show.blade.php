@extends('layouts.layout')

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
                        {{ __('main.show') }} {{ __('main.location') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-muted">
                                {{ __('main.home') }} </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('locations.index') }}" class="text-muted">
                                {{ __('main.locations') }} </a>
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
                                {{ __('main.show') }} {{ __('main.location') }} : # {{ $show->id }}
                            </h3>
                            <div class="card-toolbar">
                                <a title="{{ __('main.create') }} {{ __('main.location') }}"
                                   href="{{ route('locations.create') }}"
                                   class="btn btn-light-primary font-weight-bolder mr-2">
                                    <i class="flaticon2-plus"
                                       style="color: #FFF"></i> {{ __("main.add") }} {{ __("main.location") }} </a>
                                <a title="{{ __('main.delete') }} {{ __('main.location') }}"
                                   href="{{ route('locations.destroy', $show->id) }}"
                                   class="btn btn-light-danger font-weight-bolder mr-2" data-toggle="modal"
                                   data-target="#delete_{{$show->id}}">
                                    <i class="flaticon2-trash"></i> {{ __("main.delete") }} {{ __("main.location") }}
                                </a>
                                <a title="{{ __('main.edit') }} {{ __('main.location') }}"
                                   href="{{ route('locations.edit', $show->id) }}"
                                   class="btn btn-light-warning font-weight-bolder mr-2">
                                    <i class="flaticon2-edit"></i> {{ __("main.edit") }} {{ __("main.location") }} </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class="ml-3"><span>{{ __("main.name") }} : </span></strong>
                                        <span>{{ $show->name ?? 'N/A' }} </span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.parent") }} : </span></strong>
                                        <span>{{$show->parent ? $show->parent->name : 'N/A'}}</span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.type") }} : </span></strong>
                                        <span>{{$show->type ?? 'N/A' }}</span>
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


    <div class="modal fade" id="delete_{{$show->id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('main.delete') }} {{ __('main.location') }}
                        : {{ __('main.locations') }} #({{ $show->name }})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('locations.destroy', $show->id) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <div class="modal-body">
                        {{ __('main.delete') }} {{ __('main.locations') }}: {{ __('main.locations') }}
                        #({{ $show->name }})
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






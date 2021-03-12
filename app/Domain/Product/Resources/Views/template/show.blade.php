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
                        {{ __('main.show') }} {{ __('main.template') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-muted">
                                {{ __('main.home') }} </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('templates.index') }}" class="text-muted">
                                {{ __('main.templates') }} </a>
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
                                {{ __('main.show') }} {{ __('main.template') }} : # {{ $show->id }}
                            </h3>
                            <div class="card-toolbar">
                                <a title="{{ __('main.create') }} {{ __('main.template') }}"
                                   href="{{ route('templates.create') }}"
                                   class="btn btn-light-primary font-weight-bolder mr-2">
                                    <i class="flaticon2-plus"
                                       style="color: #FFF"></i> {{ __("main.add") }} {{ __("main.template") }} </a>
                                <a title="{{ __('main.create') }} {{ __('main.product-to-template') }}"
                                   href="{{ route('template_product.create',$show->id) }}"
                                   class="btn btn-light-primary font-weight-bolder mr-2">
                                    <i class="flaticon2-plus"
                                       style="color: #FFF"></i> {{ __("main.add") }} {{ __("main.product-to-template") }} </a>
                                <a title="{{ __('main.delete') }} {{ __('main.template') }}"
                                   href="{{ route('templates.destroy', $show->id) }}"
                                   class="btn btn-light-danger font-weight-bolder mr-2" data-toggle="modal"
                                   data-target="#delete_{{$show->id}}">
                                    <i class="flaticon2-trash"></i> {{ __("main.delete") }} {{ __("main.template") }} </a>
                                <a title="{{ __('main.edit') }} {{ __('main.template') }}"
                                   href="{{ route('templates.edit', $show->id) }}"
                                   class="btn btn-light-warning font-weight-bolder mr-2">
                                    <i class="flaticon2-edit"></i> {{ __("main.edit") }} {{ __("main.template") }} </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.name") }} : </span></strong>
                                        <span>{{ $show->name ?? 'N/A' }} </span>
                                    </div>
                                    <hr>
                                </div>
                              
                             
                            

                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.status") }} : </span></strong>
                                        <span>{{ $show->status ? __("main.{$show->status}") : 'N/A' }} </span>
                                    </div>
                                    <hr>
                                </div>

                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.creator") }} : </span></strong>
                                        <span>{{ $show->user->name ?? 'N/A' }} </span>
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
                                <br>
                                <br>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    {{-- // products grid --}}
<div class="flex-row-fluid container-fluid  py-2 py-lg-6    mt-5">
    <div class="card card-custom card-stretch gutter-b">
        <div class="card-body">
    <div class="row ">
        <!--begin::Product-->

        @foreach ($template_products as $product)
        <div class="col-md-4 col-lg-12 col-xxl-4">
            <div class="card card-custom gutter-b card-stretch">
                <div class="card-body d-flex flex-column rounded bg-light justify-content-between">
                    <div class="text-center rounded mb-7">
                        <img src="{{ $product['image'] }}" class="mw-100 w-200px">
                    </div>
                    <div>
                        <h4 class="font-size-h5">
                            <a href="{{ route("products.show",$product["id"]) }}" class="text-dark-75 font-weight-bolder">{{ $product["name"] }}</a>
                        </h4>
                     <div class="d-flex justify-content-between">
                        <div class="font-size-h6 text-muted font-weight-bolder">{{ $product["price"] }}</div>
                        <div class="font-size-h6 text-muted font-weight-bolder float-right">{{ $product["quantity"] }}</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        <!--end::Product-->
       
    </div>
</div>
</div>
</div>  
{{-- {{ dd(1) }} --}}











    <div class="modal fade" id="delete_{{$show->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('main.delete') }} {{ __('main.template') }}
                        : {{ __('main.templates') }} #({{ $show->name }})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('templates.destroy', $show->id) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <div class="modal-body">
                        {{ __('main.delete') }} {{ __('main.templates') }}: {{ __('main.templates') }} #({{ $show->name }})
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

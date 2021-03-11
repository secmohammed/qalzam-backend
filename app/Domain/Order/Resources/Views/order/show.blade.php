@extends('theme.app')

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
                        {{ __('main.show') }} {{ __('main.reservation') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-muted">
                                {{ __('main.home') }} </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('orders.index') }}" class="text-muted">
                                {{ __('main.orders') }} </a>
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
                                {{ __('main.show') }} {{ __('main.reservation') }} : # {{ $show->id }}
                            </h3>
                            <div class="card-toolbar">
                                <a title="{{ __('main.create') }} {{ __('main.reservation') }}"
                                   href="{{ route('orders.create') }}"
                                   class="btn btn-light-primary font-weight-bolder mr-2">
                                    <i class="flaticon2-plus"
                                       style="color: #FFF"></i> {{ __("main.add") }} {{ __("main.reservation") }} </a>
                                <a title="{{ __('main.delete') }} {{ __('main.reservation') }}"
                                   href="{{ route('orders.destroy', $show->id) }}"
                                   class="btn btn-light-danger font-weight-bolder mr-2" data-toggle="modal"
                                   data-target="#delete_{{$show->id}}">
                                    <i class="flaticon2-trash"></i> {{ __("main.delete") }} {{ __("main.reservation") }}
                                </a>
                                <a title="{{ __('main.edit') }} {{ __('main.reservation') }}"
                                   href="{{ route('orders.edit', $show->id) }}"
                                   class="btn btn-light-warning font-weight-bolder mr-2">
                                    <i class="flaticon2-edit"></i> {{ __("main.edit") }} {{ __("main.reservation") }} </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class="ml-3"><span>{{ __("main.user") }} : </span></strong>
                                        <span>{{ $show->user->name  }} </span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class="ml-3"><span>{{ __("main.creator") }} : </span></strong>
                                        <span>{{ $show->creator->name }} </span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class="ml-3"><span>{{ __("main.branch") }} : </span></strong>
                                        <span>{{ $show->branch->name }}  </span>
                                    </div>
                                    <hr>
                                    </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class="ml-3"><span>{{ __("main.delivery_guy") }} : </span></strong>
                                        {{-- @dd($show,$show->deliverersWithFee()->first()) --}}
                                        <span>{{ $show->deliverers->first()->name  ?? 'N/A'}} with Fee {{ $show->delivery_fee }} </span>
                                    </div>
                                    <hr>
                                    </div>

                                     



                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class="ml-3"><span>{{ __("main.status") }} : </span></strong>
                                        <span>{{ $show->status  }} </span>
                                    </div>
                                    <hr>
                                </div>
                                @if($show->order)
                                  <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.products") }} : </span></strong>
                                        @if ($show->order->products->count())
                                        <ul>
                                            @foreach($show->order->products as $product)
                                                <li>{{ $product->name }} </li>
                                            @endforeach
                                        </ul>
                                        @else
                                         N/A
                                        @endif
                                    </div>
                                    <hr>
                                </div>
                                @endif

                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.start_date") }} : </span></strong>
                                        <span>{{$show->start_date ?? 'N/A'}}</span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.end_date") }} : </span></strong>
                                        <span>{{$show->end_date ?? 'N/A'}}</span>
                                    </div>
                                    <hr>
                                </div>

                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.total_price") }} : </span></strong>
                                        <span>{{$show->formatted_total_price }}</span>
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



  
    {{-- // products grid --}}
    <div class="flex-row-fluid container-fluid  py-2 py-lg-6    mt-5">
        <div class="card card-custom card-stretch gutter-b">
            <div class="card-body">
        <div class="row ">
            <!--begin::Product-->
    
            @foreach ($order_products as $product)
            {{-- @dd($product); --}}
            <div class="col-md-4 col-lg-12 col-xxl-4">
                <div class="card card-custom gutter-b card-stretch">
                    <div class="card-body d-flex flex-column rounded bg-light justify-content-between">
                        <div class="text-center rounded mb-7">
                            {{-- <img src="{{ $product->image }}" class="mw-100 w-200px"> --}}
                        </div>
                        <div>
                            <h4 class="font-size-h5">
                                <a href="{{ route("products.show",$product->id) }}" class="text-dark-75 font-weight-bolder">{{ $product->name }}</a>
                            </h4>
                         <div class="d-flex justify-content-between">
                            <div class="font-size-h6 text-muted font-weight-bolder">{{ $product->formatted_price }}</div> 
                            <div class="font-size-h6 text-muted font-weight-bolder float-right">{{ $product->quantity }}</div> 
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













    <div class="modal fade" id="delete_{{$show->id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('main.delete') }} {{ __('main.reservation') }}
                        : {{ __('main.orders') }} #({{ $show->name }})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('orders.destroy', $show->id) }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <div class="modal-body">
                        {{ __('main.delete') }} {{ __('main.orders') }}: {{ __('main.orders') }}
                        #({{ $show->id }})
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

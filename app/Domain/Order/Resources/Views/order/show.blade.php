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
                        {{ __('main.show') }} {{ __('main.order') }} </h5>
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
                    <div class="card card-custom gutter-b">
                           <div class="card-header">
                            <h3 class="card-title">
                                {{ __('main.show') }} {{ __('main.order') }} : # {{ $show->id }}
                            </h3>
                            <div class="card-toolbar">
                                <a title="{{ __('main.create') }} {{ __('main.order') }}"
                                   href="{{ route('orders.create') }}"
                                   class="btn btn-light-primary font-weight-bolder mr-2">
                                    <i class="flaticon2-plus"
                                       style="color: #FFF"></i> {{ __("main.add") }} {{ __("main.order") }} </a>
                                <a title="{{ __('main.delete') }} {{ __('main.order') }}"
                                   href="{{ route('orders.destroy', $show->id) }}"
                                   class="btn btn-light-danger font-weight-bolder mr-2" data-toggle="modal"
                                   data-target="#delete_{{$show->id}}">
                                    <i class="flaticon2-trash"></i> {{ __("main.delete") }} {{ __("main.order") }} </a>
                                <a title="{{ __('main.edit') }} {{ __('main.order') }}"
                                   href="{{ route('orders.edit', $show->id) }}"
                                   class="btn btn-light-warning font-weight-bolder mr-2">
                                    <i class="flaticon2-edit"></i> {{ __("main.edit") }} {{ __("main.order") }} </a>
                            </div>

                        </div>
                                            <div class="card-body p-0">
                                                <!-- begin: Invoice-->
                                                <!-- begin: Invoice header-->
                                                <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                                                    <div class="col-md-10">
                                                        <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                                            <h1 class="display-4 font-weight-boldest mb-10">ORDER DETAILS</h1>
                                                            <div class="d-flex flex-column align-items-md-end px-0">
                                                                <!--begin::Logo-->
                                                                <a href="#" class="mb-5">
                                                                    <img src="{{ asset('assets/images/qalzam-logo.svg') }}" alt="">
                                                                </a>
                                                                <!--end::Logo-->
                                                                <span class="d-flex flex-column align-items-md-end opacity-70">
                                                                    <span>{{ $show->branch->name }} </span>
                                                                    <span> {{ $show->branch->address_1 . ' ' .$show->branch->location->prevNodes()->get()->push($show->branch->location)->reverse()->implode('name', ',') }} </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="border-bottom w-100"></div>
                                                        <div class="d-flex justify-content-between pt-6">
                                                            <div class="d-flex flex-column flex-root">
                                                                <span class="font-weight-bolder mb-2">ORDER DATE</span>
                                                                <span class="opacity-70">{{ $show->created_at->toDateTimeString() }}</span>
                                                            </div>
                                                            <div class="d-flex flex-column flex-root">
                                                                <span class="font-weight-bolder mb-2">ORDER NO.</span>
                                                                <span class="opacity-70">{{ $show->id}}</span>
                                                            </div>
                                                            <div class="d-flex flex-column flex-root">
                                                                <span class="font-weight-bolder mb-2">DELIVERED TO.</span>
                                                                <span class="opacity-70">{{ $show->user->full_address }}
                                                                <br> By {{ optional($show->deliverers->first())->name ?? 'N/A'}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end: Invoice header-->
                                                <!-- begin: Invoice body-->
                                                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                                                    <div class="col-md-10">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="pl-0 font-weight-bold text-muted text-uppercase">Ordered Items</th>
                                                                        <th class="text-right font-weight-bold text-muted text-uppercase">Qty</th>
                                                                        <th class="text-right font-weight-bold text-muted text-uppercase">Unit Price</th>
                                                                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($show->products as $product)
                                                                        <tr class="font-weight-boldest border-bottom-0">
                                                                            <td class="border-top-0 pl-0 py-4 d-flex align-items-center">
                                                                            <!--begin::Symbol-->
                                                                            <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
                                                                                <div class="symbol-label" style="background-image: url({{ $product->getFirstMediaUrl('product-variation-images') }})"></div>
                                                                            </div>
                                                                            <!--end::Symbol-->
                                                                            {{ $product->name }} </td>
                                                                            <td class="border-top-0 text-right py-4 align-middle">{{ $product->pivot->quantity }} </td>
                                                                            <td class="border-top-0 text-right py-4 align-middle">{{ $product->price->formatted() }}</td>
                                                                            <td class="text-primary border-top-0 pr-0 py-4 text-right align-middle">{{ $product->pivot->quantity * $product->price->amount() }} </td>
                                                                        </tr>

                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end: Invoice body-->
                                                <!-- begin: Invoice footer-->
                                                <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0 mx-0">
                                                    <div class="col-md-10">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="font-weight-bold text-muted text-uppercase">PAYMENT TYPE</th>
                                                                        <th class="font-weight-bold text-muted text-uppercase">PAYMENT STATUS</th>
                                                                        <th class="font-weight-bold text-muted text-uppercase">PAYMENT DATE</th>
                                                                        <th class="font-weight-bold text-muted text-uppercase text-right">TOTAL PAID</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="font-weight-bolder">
                                                                        <td>Cash On Delivery</td>
                                                                        <td>{{ $show->status }} </td>
                                                                        <td>{{ $show->created_at->toDateTimeString() }} </td>
                                                                        <td class="text-primary font-size-h3 font-weight-boldest text-right">{{ $show->total()->formatted() }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end: Invoice footer-->
                                                <!-- begin: Invoice action-->
                                                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                                                    <div class="col-md-10">
                                                        <div class="d-flex justify-content-between">
                                                            <a href="{{ route('orders.pdf',$show->id) }}" title="{{ __('main.export') }} {{ __('main.order') }}" class="btn btn-light-primary font-weight-bold">Download Order Details</a>
                                                            <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Order Details</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end: Invoice action-->
                                                <!-- end: Invoice-->
                                            </div>
                                        </div>
                                        <!--end::Card-->
                </div>
            </div>
        </div>
    </div>









    <div class="modal fade" id="delete_{{$show->id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('main.delete') }} {{ __('main.order') }}
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

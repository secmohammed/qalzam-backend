@extends('theme.app')

@push('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.9.2/tailwind.min.css"
          integrity="sha512-l7qZAq1JcXdHei6h2z8h8sMe3NbMrmowhOl+QkP3UhifPpCW2MC4M0i26Y8wYpbz1xD9t61MLT9L1N773dzlOA=="
          crossorigin="anonymous"/>
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.min.js" defer></script>

@endpush

@section('content')

    <div class="subheader subheader-transparent " id="kt_subheader">
        <div class="container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Mobile Toggle-->
                <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none"
                        id="kt_subheader_mobile_toggle">
                    <span></span>
                </button>
                <!--end::Mobile Toggle-->
                {{-- {{ dd(1) }} --}}

                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class=" text-dark font-weight-bold my-1 mr-5 {{ GetLanguage() == 'ar' ? 'ml-2' : '' }}">
                        {{ __('main.show-all') }} {{ __('main.product_variation') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-muted">
                                {{ __('main.home') }} </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('product_variations.index') }}" class="text-muted">
                                {{ __('main.product_variations') }} </a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->

        </div>
    </div>

    <div class="card card-custom gutter-b">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('main.product_variations') }}
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('product_variations.create') }}"
                   class="btn btn-light-primary font-weight-bolder mr-2">
                    <i class="ki ki-plus icon-sm"
                       style="color: #fff"></i> {{ __('main.create') }} </a>
            </div>

        </div>
        <div class="card-body">
            <form action="{{route('product_variations.delete-all', ['type' => request('type')])}}" method="post">
                @csrf
                @method('DELETE')
            {!! $dataTable->table(['class' => 'table table-separate table-head-custom table-checkable'])  !!}
        
            <button type="submit" id="testing"
            class="btn btn-danger font-weight-bolder mr-2">
             <i class="fa fa-trash icon-sm"
                style="color: #fff"></i> {{ __('main.delete') }} </button>

        
        </div>
    </div>
@endsection

@push('scripts')

    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('assets/js/pages/crud/datatables/basic/basic.js')}}"></script>
    <!--end::Page Scripts-->
    {!! $dataTable->scripts() !!}
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {   //same as: $(function() {
            $('#dataTablesCheckbox').change(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            })
        });
    </script>
@endpush

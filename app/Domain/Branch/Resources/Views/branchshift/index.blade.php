@extends('theme.app')

@push('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.9.2/tailwind.min.css"
integrity="sha512-l7qZAq1JcXdHei6h2z8h8sMe3NbMrmowhOl+QkP3UhifPpCW2MC4M0i26Y8wYpbz1xD9t61MLT9L1N773dzlOA=="
crossorigin="anonymous"/>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.min.js" defer></script>



@endpush

{{-- @section('sub_header')
    @component('backend.components.sub-header')
        @slot('title')
            {{ $title }}
        @endslot
    @endcomponent
@endsection --}}

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

            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <h5 class=" text-dark font-weight-bold my-1 mr-5 {{ GetLanguage() == 'ar' ? 'ml-2' : '' }}">
                    {{ __('main.show-all') }} {{ __('main.branch-shifts') }} </h5>
                <!--end::Page Title-->

                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}" class="text-muted">
                            {{ __('main.home') }} </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('branch_shifts.index') }}" class="text-muted">
                            {{ __('main.branch-shifts') }} </a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->

    </div>
</div>

<livewire:branch-shift-datatable
    model="App\Domain\Branch\Entities\BranchShift"
    exclude="updated_at"
    hideable="select"
    params="branch_shifts"
/>
@endsection

@push('scripts')
    <!--begin::Page Vendors(used by this page) -->
    <script src="{{ asset("layout-dist/plugins/datatables/jquery.dataTables.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("layout-dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}" type="text/javascript"></script>
    <!--end::Page Vendors -->
@endpush

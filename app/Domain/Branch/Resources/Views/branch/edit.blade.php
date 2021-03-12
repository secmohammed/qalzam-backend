@extends('theme.app')

@section('content')
    <!--begin::Subheader-->
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
                        {{ __('main.add') }} {{ __('main.branch') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-muted">
                                {{ __('main.home') }} </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('branches.index') }}" class="text-muted">
                                {{ __('main.branches') }} </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-muted">
                                {{ __('main.edit') }} {{ __('main.branches') }} </a>
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
                                {{ __('main.add') }} {{ __('main.branch') }}
                            </h3>
                            <div class="card-toolbar">
                                <a href="{{ route('branches.index') }}"
                                   class="btn btn-light-primary font-weight-bolder mr-2">
                                    <i class="ki ki-long-arrow-back icon-sm"
                                       style="color: #fff"></i> {{ __("main.back") }} </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <form class="form" action="{{ route('branches.update', $edit->id) }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row container-fluid mb-5">
                                    <div class="col-xl-0"></div>
                                    <div class="col-xl-10">
                                        @include("{$alias}::branch._partials._fields", [
                                            'action' => 'edit',
                                            'edit' => $edit,
                                            'users' => $users,
                                            'branch_managers' => $branch_managers,
                                            'deliverers' => $deliverers,
                                            'selected_users' => $selected_users,
                                            'locations' => $locations
                                        ])
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-1"></div>
                                    <div class="col-lg-2">
                                        <button type="submit"
                                                class="btn btn-block btn-sm btn-light-primary font-weight-bolder text-uppercase py-4">{{ __("main.edit") }}
                                            &nbsp; {{ __("main.branch") }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js?v=7.1.5') }}"></script>
    <script>
        $('.select2').select2({
                        placeholder: '{{ __('main.select_option') }}'


        });

    </script>

@endpush

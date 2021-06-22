@extends('theme.app')

@push('styles')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
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

                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class=" text-dark font-weight-bold my-1 mr-5 {{ GetLanguage() == 'ar' ? 'ml-2' : '' }}">
                        {{ __('main.show-all') }} {{ __('main.orders') }} </h5>
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

    <div class="card card-custom gutter-b">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('main.orders') }}
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('orders.create') }}"
                   class="btn btn-light-primary font-weight-bolder mr-2">
                    <i class="ki ki-plus icon-sm"
                       style="color: #fff"></i> {{ __('main.create') }} </a>
            </div>

        </div>
        <div class="card-body">
            <form action="{{route('orders.delete-all', ['type' => request('type')])}}" method="post">
                @csrf
                @method('DELETE')
            {!! $dataTable->table(['class' => 'table table-separate table-head-custom table-checkable'])  !!}
            <button type="submit" id="testing"
            class="btn btn-danger font-weight-bolder mr-2">
             <i class="fa fa-trash icon-sm"
                style="color: #fff"></i> {{ __('main.delete') }} </button>
            <a 
            class="btn btn-secondary font-weight-bolder mr-2"
            data-toggle="modal" data-target="#assign-delivery"
            >
           {{ __('main.assign-to-delivery') }} </a>

        </div>
    </div>
    <div class="modal fade" id="assign-delivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">assign delivery</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger hidden" id="errorContainerLogin">
                    <svg width="30" height="36" viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30.3317 9.61971L31.7399 10.699C35.0394 13.2307 37.432 16.7611 38.5611 20.7637C39.6901 24.7664 39.4951 29.0267 38.005 32.9094C36.5149 36.7921 33.8097 40.0892 30.2927 42.3088C26.7757 44.5284 22.6355 45.5517 18.4894 45.226C14.3434 44.9003 10.4137 43.2431 7.28642 40.5016C4.15914 37.7601 2.00185 34.0812 1.13628 30.0134C0.270714 25.9457 0.743244 21.7071 2.4834 17.9299C4.22355 14.1526 7.1381 11.0391 10.7924 9.05358M20.4942 1.31382L20.7017 27.5582" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div class="contant">
                        <p>هناك خطأ ما , يرجى إعاده المحاولة</p>
                        <div class="" id="loginErrors"></div>
                    </div>
                </div>
                <div class="form-group row w-full">
                    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.deliverers") }}</label>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <select id="delivery_id" class="form-control  select2" style="width: 100%" name="delivery_id" data-placeholder="{{ __('main.select') .' '.__('main.deliverers')  }}">
                            <option label="Label"></option>
                         
                            @foreach ($deliverers as $delivery)
                            <option
                            value="{{$delivery->id }}" >{{ $delivery->name}}</option>
                                  
                            @endforeach
                              </select>
                     
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button"  id="save-delivery" class="btn btn-primary">Save </button>
            </div>
          </div>
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
<script src="{{ asset('assets/js/pages/crud/forms/widgets/select2.js?v=7.1.5') }}"></script>
<script>
    $('.select2').select2({
        placeholder: '{{ __('main.select_option') }}'
    });

</script>
    <script>
        $(document).ready(function() {   //same as: $(function() {
            $('#dataTablesCheckbox').change(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            })
        });
        $(document).ready(function() {   //same as: $(function() {
            $('#save-delivery').click(function(){
                let orders = $("input[name='items[]']")
                .map(function(){ 
                if(!$(this)[0].checked)return ;
                return $(this).val()
                }).get();
                let delivery_id = $('#delivery_id').val();
            let _token   = "{!! csrf_token() !!}";
console.log(delivery_id,_token)
                $.ajax({
                url: "{!! route('orders.assign.deliverer') !!}",
                type:"POST",
                data:{
                    orders,
                    delivery_id,
                    _token
                },
                success:function(response){
                    console.log(response)
                    window.location.reload()
                },
                error:function (response){
                    $("#loginErrors").empty();
                    $("#errorContainerLogin").show();
                    $.each(response.responseJSON.errors, function (key, item)
                    {

                        console.log(item)
                        $("#loginErrors").append("<li class='text-light m-2 font-weight-bold'>"+ key +' ' +item+"</li>")
                    });
                }
            });
        })




            });
        


    </script>
@endpush
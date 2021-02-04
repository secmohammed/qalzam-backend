@extends('theme.auth')

@section('body-class','login-page')

@push('styles')
    <link href="{{asset('css/login-1.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="login-form login-signin">
        <!--begin::Form-->
        <form class="form" action="{{url('login')}}" method="post" novalidate="novalidate" id="">
        @csrf
        <!--begin::Title-->
            <div class="pb-13 pt-lg-0 pt-5">
                <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Welcome to Qalzam</h3>
            </div>
            <!--begin::Title-->
            <!--begin::Form group-->
            <div class="form-group row">
                <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                <input
                    class="form-control form-control-solid h-auto py-7 px-6 rounded-lg {{$errors->has('email') ? 'is-invalid':''}}"
                    type="email" name="email" autocomplete="off"/>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    @if($errors->has('email'))
                        <div class="alert alert-danger w-100 m-0" role="alert">
                            {{$errors->first('email')}}
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="form-group row">
                <label class="font-size-h6 font-weight-bolder text-dark">Password</label>

                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password"
                       name="password" autocomplete="off"/>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    @if($errors->has('password'))
                        <div class="alert alert-danger w-100 m-0" role="alert">
                            {{$errors->first('password')}}
                        </div>
                    @endif
                    @if(isset($customError))
                        <div class="alert alert-danger w-100 m-0" role="alert">
                            {{$customError}}
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Form group-->
            <!--begin::Action-->





            <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                <a href="forget_password" class="text-dark-50 text-hover-primary my-3 mr-2"
                   id="kt_login_forgot">Forgot Password </a>
                <button type="submit" id="kt_login_signin_submit"
                        class="btn btn-primary font-weight-bold px-9 py-4 my-3">Sign In</button>
            </div>
            <!--end::Action-->
        </form>
        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('js/pages/custom/login/login-general.js')}}"></script>
    <!--end::Page Scripts-->
@endpush

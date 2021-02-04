@extends('theme.auth')

@section('content')
    <div class="login-form login-signin">
        <!--begin::Form-->
        <form class="form" novalidate="novalidate" id="kt_login_forgot_form" action="{{ route('password.email') }}" method="POST">
        @csrf
        <!--begin::Title-->
            <div class="pb-13 pt-lg-0 pt-5">
                <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password ?</h3>
                <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
            </div>
            <!--end::Title-->
            <!--begin::Form group-->
            <div class="form-group">
                <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="email" placeholder="Enter your Email" name="email"/>
            </div>
            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="form-group d-flex justify-content-between pb-lg-0">
                <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Send Password Reset Link</button>
                <a href="{{ route('login') }}" type="button" id="" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</a>
            </div>
            <!--end::Form group-->
        </form>
        <!--end::Form-->
    </div>

@endsection

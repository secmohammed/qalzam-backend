@extends('theme.auth')

@section('content')
    <div class="login-form login-reset">
        <!--begin::Form-->
        <form class="form" action="{{route('auth.reset-password',['resetToken' => Arr::last(request()->segments())])}}" method="post" novalidate="novalidate" id="kt_login_forgot_form">
            @method('put')
            @csrf
            <input type="hidden" name="token" value="{{Arr::last(request()->segments())}}">
            <input type="hidden" name="email" value="{{Request::get('email')}}">
            <!--begin::Title-->
            <div class="pb-13 pt-lg-0 pt-5">
                <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Reset Password</h3>
                <p class="text-muted font-weight-bold font-size-h4">You are only one step a way from your new password, recover your password now.</p>

            </div>
            <!--end::Title-->
            <!--begin::Form group-->
            <div class="form-group mb-4">
                <input type="password" name="password" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6  {{$errors->has('password')?'is-invalid':''}}" placeholder="Password">
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($errors->has('password'))
                        <div class="alert alert-danger w-100 m-0" role="alert">
                            {{$errors->first('password')}}
                        </div>
                    @endif
                </div>
            </div>
            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="input-group mb-4 mt-2">
                <input type="password" name="password_confirmation" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6  {{$errors->has('password')?'is-invalid':''}}" placeholder="Confirm Password">
            </div>
            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="form-group d-flex justify-content-between pb-lg-0">
                <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">
                    Change password
                </button>
                <a href="{{ route('login') }}" type="button" id="" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">
                    Cancel
                </a>
            </div>
            <!--end::Form group-->
        </form>
        <!--end::Form-->
    </div>
@endsection

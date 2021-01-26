@extends('layouts.layout-basic')

@section('body-class','login-page')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-column">
        <div class="text-center mb-10 mb-lg-15">
        <h3 class="font-size-h1">Reset Password</h3>
        <p class="text-muted font-weight-bold">You are only one step a way from your new password, recover your password now</p>
    </div>

        <form action="{{route('reset_password',['token'=>Arr::last(request()->segments())])}}" method="post">

        @csrf
        <input type="hidden" name="token" value="{{Arr::last(request()->segments())}}">

        <div class="form-group">
            <input
                class="form-control form-control-solid h-auto py-5 px-6 {{$errors->has("password")?'is-invalid':''}}"
                type="password" name="password"
                placeholder="{{__('main.Password')}}"/>
            @if($errors->has('password'))
                <div class="fv-plugins-message-container">
                    <div class="fv-help-block">  {{$errors->first('password')}} </div>
                </div>
            @endif
        </div>

        <div class="form-group">
            <input class="form-control form-control-solid h-auto py-5 px-6 {{$errors->has("password")?'is-invalid':''}}"
                   type="password" name="password_confirmation" placeholder="{{__('main.Confirm Password')}}"/>
        </div>

        <!--begin::Action-->
        <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
            <a href="{{route('login')}}" class="text-dark-50 text-hover-primary my-3 mr-2"
               id="kt_login_forgot">{{__('main.Return to login')}}</a>
            <button type="submit" id="kt_login_signin_submit"
                    class="btn btn-primary btn-sm font-weight-bold px-9 my-3">{{__('main.Change password')}}</button>
        </div>
        <!--end::Action-->
    </form>
    </div>
@endsection

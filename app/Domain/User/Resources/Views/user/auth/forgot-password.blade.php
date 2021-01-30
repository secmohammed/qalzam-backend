@extends('theme.auth')

@section('body-class','login-page')



@section('content')

<div class="d-flex justify-content-between align-items-center flex-column">
    <div class="text-center mb-10 mb-lg-15">
        <h3 class="font-size-h1">Forgot Password</h3>
        <p class="text-muted font-weight-bold">you forgot your password
            <br/>
            Here you can easily retrieve a new password</p>
    </div>

    <form action="{{route('password.email')}}" method="post">
        @csrf

        <div class="form-group">
            <input class="form-control form-control-solid h-auto py-5 px-4 {{$errors->has("email")?'is-invalid':''}}"
                   type="email" placeholder="email" name="email" autocomplete="off"/>
            @if($errors->has('email'))
                <div class="fv-plugins-message-container">
                    <div class="fv-help-block">  {{$errors->first('email')}} </div>
                </div>
            @endif
        </div>

        <!--begin::Action-->
        <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
            <a href="{{route('login')}}" class="text-dark-50 text-hover-primary my-6 mr-20"
               id="kt_login_forgot">Return to login</a>
            <button type="submit" id="kt_login_signin_submit"
                    class="btn btn-primary btn-sm font-weight-bold px-9  my-3">Request new password</button>
        </div>
        <!--end::Action-->
    </form>
</div>

@endsection

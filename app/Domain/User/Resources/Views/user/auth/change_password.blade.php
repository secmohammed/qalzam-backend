@extends('theme.auth')

@section('content')
    <div class="card" style="border-radius:0.72rem">
        <div class="card-body login-card-body">
            <div class="text-center mb-10 mt-5">
                <h3 class="font-size-h1">{{ __("main.change_password") }}</h3>
            </div>
            <form class="form" action="{{url('change-password')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label text-left {{ GetLanguage() == 'en' ? 'offset-lg-1' : '' }} col-lg-2 col-sm-12">{{ __("main.old_password") }}</label>
                    <div class="col-lg-8 col-md-9 col-sm-12">
                        <input name="old_password" type="password" class="form-control {{$errors->has('old_password') ? 'is-invalid':''}}" placeholder="{{ __("main.old_password") }}">
                        <div class="row">
                            <div class="col-md-12">
                                @if($errors->has('old_password'))
                                    <div class="alert alert-danger w-100 m-0" role="alert">
                                        {{$errors->first('old_password')}}
                                    </div>
                                @endif
                                    @if(isset($customError))
                                        <div class="alert alert-danger w-100 m-0" role="alert">
                                            {{$customError }}
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-left {{ GetLanguage() == 'en' ? 'offset-lg-1' : '' }} col-lg-2 col-sm-12">{{ __("main.password") }}</label>
                    <div class="col-lg-8 col-md-9 col-sm-12">
                        <input name="password" type="password" class="form-control {{$errors->has('password') ? 'is-invalid':''}}" placeholder="{{ __("main.password") }}">
                        <div class="row">
                            <div class="col-md-12">
                                @if($errors->has('password'))
                                    <div class="alert alert-danger w-100 m-0" role="alert">
                                        {{$errors->first('password')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-left {{ GetLanguage() == 'en' ? 'offset-lg-1' : '' }} col-lg-2 col-sm-12">{{ __("main.password_confirmation") }}</label>
                    <div class="col-lg-8 col-md-9 col-sm-12">
                        <input name="password_confirmation" type="password" class="form-control {{$errors->has('password') ? 'is-invalid':''}}" placeholder="{{ __("main.password_confirmation") }}">
                        <div class="row">
                            <div class="col-md-12">
                                @if($errors->has('password_confirmation'))
                                    <div class="alert alert-danger w-100 m-0" role="alert">
                                        {{$errors->first('password_confirmation')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!--begin::Action-->
        <div class="form-group d-flex flex-wrap justify-content-between align-items-center" style="margin: auto">
            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">{{ __('main.change_password') }}</button>
        </div>
        <!--end::Action-->
    </div>

@endsection

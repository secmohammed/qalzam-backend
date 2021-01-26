<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.name") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="name" type="text" class="form-control {{$errors->has('name') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->name : old('name') }}" placeholder="{{ __("main.name") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('name'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('name')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.name_ar") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="name_ar" type="text" class="form-control {{$errors->has('name_ar') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? optional($edit->translations->first(), function ($translation) use ($edit) {
                    return $translation->where('translatable_id', $edit->id)->first()->value;
               }) ?? old('name_ar') : old('name_ar') }}" placeholder="{{ __("main.name_ar") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('name_ar'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('name_ar')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.email") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="email" name="email" class="form-control {{$errors->has('email') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->email : old('email') }}" placeholder="{{ __("main.email") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('email'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('email')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.password") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="password" name="password" class="form-control {{$errors->has('password') ? 'is-invalid':''}}"
               placeholder="{{ __("main.password") }}">
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
@if ($action == 'create')
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.password_confirmation") }} <span
                style="color: red"> * </span> </label>
        <div class="col-lg-10 col-md-9 col-sm-12">
            <input type="password" name="password_confirmation"
                   class="form-control {{$errors->has('password_confirmation') ? 'is-invalid':''}}"
                   placeholder="{{ __("main.password_confirmation") }}">
        </div>
    </div>
@endif

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.mobile") }} <span
            style="color: red"> * </span> </label>

    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="number" class="form-control {{$errors->has('mobile') ? 'is-invalid':''}}" name="mobile"
               placeholder="{{ __('main.mobile') }}" value="{{ ($action == 'edit') ? $edit->mobile : old('mobile') }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('mobile'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('mobile')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.role") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('role_id') ? 'is-invalid':''}}" name="role_id">
            <option label="Label"></option>
            @foreach($roles as $role)
                <option
                    value="{{ $role->id }}" {{ ($action == 'edit') && optional($edit->roles->first())->id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('role_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('role_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.image") }}</label>

    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" name="image" class="form-control {{$errors->has('image') ? 'is-invalid':''}}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('image'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('image')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

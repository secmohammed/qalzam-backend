<x-forms.name :action="$action" :edit="$edit??null"/>


<x-forms.ar_name :action="$action" :edit="$edit??null"/>


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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.type") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('type') ? 'is-invalid':''}}" name="type">
            <option label="Label"></option>
                <option
                    value="user" {{ ($action == 'edit') && $edit->type === 'user' ? 'selected' : '' }}>User</option>
                <option
                    value="admin" {{ ($action == 'edit') && $edit->type === 'admin' ? 'selected' : '' }}>Admin</option>
                <option
                    value="branch" {{ ($action == 'edit') && $edit->type === 'branch' ? 'selected' : '' }}>Branch</option>
                <option
                    value="kitchen" {{ ($action == 'edit') && $edit->type === 'kitchen' ? 'selected' : '' }}>Kitchen</option>
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
            @if (  isset($edit)&& $edit->getFirstMediaUrl('image')&& ($action == 'edit'))
<div class="d-flex flex-row  flex-row-wrap">
 <x-forms.small_image :image="$edit->getFirstMediaUrl('image')"/>
</div>
@endif

        </div>
    </div>
</div>

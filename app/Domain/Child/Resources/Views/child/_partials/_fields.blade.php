<br>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.name_en") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="name" type="text" class="form-control {{$errors->has('name') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->name : old('name') }}" placeholder="{{ __("main.name_en") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('name'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
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
               value="{{ ($action == 'edit') ? $edit->getArAttribute('name') : old('name_ar') }}" placeholder="{{ __("main.name_ar") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('name_ar'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('name_ar')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">
        {{ __("main.birthdate") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">

        <input name="birthdate" type="text" readonly id="kt_datepicker_3" class="form-control {{$errors->has('birthdate') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->birthdate->format('Y-m-d') : old('birthdate') }}" placeholder="{{ __("main.birthdate") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('birthdate'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('birthdate')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.gender") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('gender') ? 'is-invalid':''}}" name="gender">
            <option label="Label"></option>
                <option value="male" {{ ($action == 'edit') && $edit->gender == 'male' ? 'selected' : '' }}>{{ __("main.male") }}</option>
                <option value="female" {{ ($action == 'edit') && $edit->gender == 'female' ? 'selected' : '' }}>{{ __("main.female") }}</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('gender'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('gender')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.relation") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('relation') ? 'is-invalid':''}}" name="relation">
            <option label="Label"></option>
            <option value="son" {{ ($action == 'edit') && $edit->relation == 'son' ? 'selected' : '' }}>{{ __("main.son") }}</option>
            <option value="daughter" {{ ($action == 'edit') && $edit->relation == 'daughter' ? 'selected' : '' }}>{{ __("main.daughter") }}</option>
            <option value="grand-son" {{ ($action == 'edit') && $edit->relation == 'grand-son' ? 'selected' : '' }}>{{ __("main.grand-son") }}</option>
            <option value="grand-daughter" {{ ($action == 'edit') && $edit->relation == 'grand-daughter' ? 'selected' : '' }}>{{ __("main.grand-daughter") }}</option>
            <option value="nephew" {{ ($action == 'edit') && $edit->relation == 'nephew' ? 'selected' : '' }}>{{ __("main.nephew") }}</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('relation'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('relation')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.image") }} <span
            style="color: red"> * </span> </label>

    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" name="child-avatar" class="form-control {{$errors->has('child-avatar') ? 'is-invalid':''}}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('child-avatar'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('child-avatar')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

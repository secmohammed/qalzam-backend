<br>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">
{{ __("main.name") }} <span
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">
{{ __("main.name_ar") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">

        <input name="name_ar" type="text" class="form-control {{$errors->has('name_ar') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->translations->first()->where('translatable_id', $edit->id)->first()->value : old('name_ar') }}" placeholder="{{ __("main.name_ar") }}">
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
    <label
        class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.parent") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">

        <select class="form-control select2 {{$errors->has('parent_id') ? 'is-invalid':''}}" name="parent_id">
            <option label="Label"></option>
            @foreach($locations as $location)
                <option
                    value="{{$location->id}}" {{ ($action == 'edit') && $edit->parent_id == $location->id ? 'selected' : '' }}>{{$location->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('parent_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('parent_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">
{{ __("main.type") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">

        <select class="form-control select2 {{$errors->has('type') ? 'is-invalid':''}}" name="type">
            <option label="Label"></option>
            <option
                value="country" {{ ($action == 'edit') && $edit->type == 'country' ? 'selected' : '' }}>{{ __('main.country') }}</option>
            <option
                value="city" {{ ($action == 'edit') && $edit->type == 'city' ? 'selected' : '' }}>{{ __('main.city') }}</option>
            <option
                value="district" {{ ($action == 'edit') && $edit->type == 'district' ? 'selected' : '' }}>{{ __('main.district') }}</option>
            <option
                value="zone" {{ ($action == 'edit') && $edit->type == 'zone' ? 'selected' : '' }}>{{ __('main.zone') }}</option>

        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('type'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('type')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

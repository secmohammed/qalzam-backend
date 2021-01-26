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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __('main.start_date') }} <span
            style="color: red"> * </span></label>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <input type="text"
               name="start_date"
               id="start_date"
               class="form-control datetimepicker-input kt_datetimepicker_5 {{$errors->has('start_date') ? 'is-invalid':''}}"
               placeholder="{{ __('main.start_date') }}"
               value="{{ ($action == 'edit') ? $edit->start_date : '' }}"
               data-toggle="datetimepicker"
               data-target="#start_date">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('start_date'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('start_date')}}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __('main.end_date') }} <span
            style="color: red"> * </span></label>
    <div class="col-lg-4 col-md-4 col-sm-12">
        <input type="text"
               name="end_date"
               id="end_date"
               class="form-control datetimepicker-input kt_datetimepicker_5 {{$errors->has('end_date') ? 'is-invalid':''}}"
               placeholder="{{ __('main.end_date') }}"
               value="{{ ($action == 'edit') ? $edit->end_date->format('y-m-d h:i') : '' }}"
               data-toggle="datetimepicker"
               data-target="#end_date">

        <div class="row">
            <div class="col-md-12">
                @if($errors->has('end_date'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('end_date')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.min_age") }} <span
            style="color: red"> * </span> </label>

    <div class="col-lg-4 col-md-4 col-sm-12">
        <input type="number" class="form-control {{$errors->has('min_age') ? 'is-invalid':''}}" name="min_age"
               placeholder="{{ __('main.min_age') }}" value="{{ ($action == 'edit') ? $edit->min_age : old('min_age') }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('min_age'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('min_age')}}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.max_age") }} <span
            style="color: red"> * </span> </label>

    <div class="col-lg-4 col-md-4 col-sm-12">
        <input type="number" class="form-control {{$errors->has('max_age') ? 'is-invalid':''}}" name="max_age"
               placeholder="{{ __('main.max_age') }}" value="{{ ($action == 'edit') ? $edit->max_age : old('max_age') }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('max_age'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('max_age')}}
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
                <option value="video" {{ ($action == 'edit') && $edit->type == 'video' ? 'selected' : '' }}>{{ __('main.video') }}</option>
                <option value="image" {{ ($action == 'edit') && $edit->type == 'image' ? 'selected' : '' }}>{{ __('main.image') }}</option>
                <option value="check-in" {{ ($action == 'edit') && $edit->type == 'check-in' ? 'selected' : '' }}>{{ __('main.check-in') }}</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('type'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('type')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.featured") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('featured') ? 'is-invalid':''}}" name="featured">
            <option label="Label"></option>
                <option value="featured" {{ ($action == 'edit') && $edit->featured == 'featured' ? 'selected' : '' }}>{{ __('main.featured') }}</option>
                <option value="normal" {{ ($action == 'edit') && $edit->featured == 'normal' ? 'selected' : '' }}>{{ __('main.normal') }}</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('featured'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('featured')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.location_id") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('location_id') ? 'is-invalid':''}}" name="location_id">
                @foreach($locations as $location)
                <option value="{{ $location->id }}" {{ ($action == 'edit') && $edit->location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>

                @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('location_id'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('location_id')}}
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
            <option value="male" {{ ($action == 'edit') && $edit->gender == 'male' ? 'selected' : '' }}>{{ __('main.male') }}</option>
            <option value="female" {{ ($action == 'edit') && $edit->gender == 'female' ? 'selected' : '' }}>{{ __('main.female') }}</option>
            <option value="both" {{ ($action == 'edit') && $edit->gender == 'both' ? 'selected' : '' }}>{{ __('main.both') }}</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('gender'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('gender')}}
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
        <input type="file" name="competition-cover" class="form-control {{$errors->has('competition-cover') ? 'is-invalid':''}}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('competition-cover'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('competition-cover')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

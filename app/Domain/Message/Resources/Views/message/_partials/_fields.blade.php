<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.title") }} <span
    style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="title" type="text" class="form-control {{$errors->has('title') ? 'is-invalid':''}}"
        value="{{ ($action == 'edit') ? $edit->title : old('title') }}" placeholder="{{ __("main.title") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('title'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('title')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.body") }} <span
    style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <textarea name="body" type="text" class="form-control {{$errors->has('body') ? 'is-invalid':''}}"
        value="{{ ($action == 'edit') ? $edit->body : old('body') }}" placeholder="{{ __("main.body") }}"></textarea>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('body'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('body')}}
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
            value="push_notification" {{ ($action == 'edit') && $edit->type  == 'push_notification' ? 'selected' : '' }}> Push Notification</option>
            <option
            value="sms" {{ ($action == 'edit') && $edit->type  == 'sms' ? 'selected' : '' }}> SMS</option>
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
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.competition") }}  </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('competition_id') ? 'is-invalid':''}}" name="competition_id">
            <option label="Label"></option>
            @foreach($competitions as $competition)
            <option
            value="{{ $competition->id }}" {{ ($action == 'edit') && $competition->id === $edit->id ? 'selected' : '' }}>{{ $competition->name }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('competition_id'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('competition_id')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __('main.delay') }} </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text"
        name="delay"
        id="delay"
        class="form-control datetimepicker-input kt_datetimepicker_5 {{$errors->has('delay') ? 'is-invalid':''}}"
        placeholder="{{ __('main.delay') }}"
        value="{{ ($action == 'edit') ? Carbon\Carbon::parse($edit->delay)->format('d/m/Y h:i A') : '' }}"
        data-toggle="datetimepicker"
        data-target="#delay">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('delay'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('delay')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

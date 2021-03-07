<br>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.day") }}  <span
            style="color: red"> * </span></label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('day') ? 'is-invalid':''}}" name="day">
            <option label="Label"></option>
            <option value="saturday" {{ ($action == 'edit') && $edit->day == 'saturday' ? 'selected' : '' }}>{{ __('main.saturday') }}</option>
            <option value="sunday" {{ ($action == 'edit') && $edit->day == 'sunday' ? 'selected' : '' }}>{{ __('main.sunday') }}</option>
            <option value="monday" {{ ($action == 'edit') && $edit->day == 'monday' ? 'selected' : '' }}>{{ __('main.monday') }}</option>
            <option value="tuesday" {{ ($action == 'edit') && $edit->day == 'tuesday' ? 'selected' : '' }}>{{ __('main.tuesday') }}</option>
            <option value="wednesday" {{ ($action == 'edit') && $edit->day == 'wednesday' ? 'selected' : '' }}>{{ __('main.wednesday') }}</option>
            <option value="thursday" {{ ($action == 'edit') && $edit->day == 'thursday' ? 'selected' : '' }}>{{ __('main.thursday') }}</option>
            <option value="friday" {{ ($action == 'edit') && $edit->day == 'friday' ? 'selected' : '' }}>{{ __('main.friday') }}</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('day'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('day')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.start_time") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input
            class="form-control kt_timepicker_1 {{$errors->has('start_time') ? 'is-invalid':''}}"
            name="start_time"
            readonly="readonly"
            placeholder="{{ __("main.start_time") }}"
            type="text"
            value="{{ $action == 'edit' ? $edit->start_time : '' }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('start_time'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('start_time')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.end_time") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input
            class="form-control kt_timepicker_1 {{$errors->has('end_time') ? 'is-invalid':''}}"
            name="end_time"
            readonly="readonly"
            placeholder="{{ __("main.end_time") }}"
            type="text"
            value="{{ $action == 'edit' ? $edit->end_time : '' }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('end_time'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('end_time')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12 ">{{ __("main.branch") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('branch_id') ? 'is-invalid':''}}"
                name="branch_id">
            <option label="Label"></option>

            @foreach($branchs as $branch)
                <option value="{{$branch->id}}" {{ ($action == 'edit')  && $edit->branch_id == $branch->id ? 'selected' : '' }}>{{$branch->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('branch_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('branch_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

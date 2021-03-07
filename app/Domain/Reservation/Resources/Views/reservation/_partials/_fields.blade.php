<br>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12 ">{{ __("main.user") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('user_id') ? 'is-invalid':''}}"
                name="user_id">
            <option label="Label"></option>

            @foreach($users as $user)
                <option value="{{$user->id}}" {{ ($action == 'edit')  && $edit->user_id == $user->id ? 'selected' : '' }}>{{$user->name}} ({{ $user->mobile }})</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('user_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('user_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12 ">{{ __("main.accommodation") }}  <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('accommodation_id') ? 'is-invalid':''}}"
                name="accommodation_id">
            <option label="Label"></option>

            @foreach($accommodations as $accommodation)
                <option value="{{$accommodation->id}}" {{ ($action == 'edit')  && $edit->accommodation_id == $accommodation->id ? 'selected' : '' }}>{{$accommodation->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('accommodation_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('accommodation_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>



<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __('main.start_date') }} <span
            style="color: red"> * </span></label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text"
               name="start_date"
               id="start_date"
               class="form-control datetimepicker-input kt_datetimepicker_5 {{$errors->has('start_date') ? 'is-invalid':''}}"
               placeholder="{{ __('main.start_date') }}"
               value="{{ ($action == 'edit') ? $edit->start_date->format('Y/m/d h:i A') : '' }}"
               data-toggle="datetimepicker"
               data-target="#start_date">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('start_date'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('start_date')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __('main.end_date') }} <span
            style="color: red"> * </span></label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text"
               name="end_date"
               id="end_date"
               class="form-control datetimepicker-input kt_datetimepicker_5 {{$errors->has('end_date') ? 'is-invalid':''}}"
               placeholder="{{ __('main.end_date') }}"
               value="{{ ($action == 'edit') ? $edit->end_date->format('Y/m/d h:i A') : '' }}"
               data-toggle="datetimepicker"
               data-target="#end_date">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('end_date'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('end_date')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

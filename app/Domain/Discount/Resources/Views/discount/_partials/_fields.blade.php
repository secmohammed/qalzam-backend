<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.code") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="code" type="text" class="form-control {{$errors->has('code') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->code : old('code') }}" placeholder="{{ __("main.code") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('code'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('code')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.status") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('status') ? 'is-invalid':''}}" name="status">
            <option label="Label"></option>
                <option
                    value="active" {{ ($action == 'edit') && $edit->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option
                    value="inactive" {{ ($action == 'edit') && $edit->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('status'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('status')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.number_of_usage") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="number"  name="number_of_usage" min="10" max="10000" class="form-control {{$errors->has('number_of_usage') ? 'is-invalid':''}}"
               placeholder="{{ __("main.number_of_usage") }}" />
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('number_of_usage'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('number_of_usage')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.percentage") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="number" step="any" name="percentage" min="1" max="100" class="form-control {{$errors->has('percentage') ? 'is-invalid':''}}"
               placeholder="{{ __("main.percentage") }}" />
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('percentage'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('percentage')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.users") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('users') ? 'is-invalid':''}}" name="users" multiple>
            <option label="Label"></option>
            @foreach($users as $user)
                <option
                    value="{{ $user->id }}" {{ ($action == 'edit') && $discount->users->contains($user) ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('users'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('users')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.broadcast") }}</label>
        <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('brodcast') ? 'is-invalid':''}}" name="broadcast">
            <option label="Label"></option>
                <option value="1">Yes</option>
                <option value="0" >No</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('broadcast'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('broadcast')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __('main.expires_at') }} <span
            style="color: red"> * </span></label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text"
               name="expires_at"
               id="expires_at"
               class="form-control datetimepicker-input kt_datetimepicker_5 {{$errors->has('expires_at') ? 'is-invalid':''}}"
               placeholder="{{ __('main.expires_at') }}"
               value="{{ ($action == 'edit') ? $edit->expires_at : '' }}"
               data-toggle="datetimepicker"
               data-target="#expires_at">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('expires_at'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('expires_at')}}
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

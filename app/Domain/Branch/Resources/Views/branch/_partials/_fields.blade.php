<br>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">
        {{ __("main.name_en") }}
        <span style="color: red"> * </span>
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="name" type="text" class="form-control {{$errors->has('name') ? 'is-invalid':''}}"
        value="{{ ($action == 'edit') ? $edit->name : old('name') }}" placeholder="{{ __("main.name_en") }}">
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.user") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('user_id') ? 'is-invalid':''}}" name="user_id" data-placeholder="{{ __('main.select') .' '.__('main.user')  }}">
            <option label="Label"></option>
            @foreach($users as $user)
            <option
            value="{{$user->id}}" {{ ($action == 'edit') && $edit->user_id == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.location") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('location_id') ? 'is-invalid':''}}" name="location_id" data-placeholder="{{ __('main.select') .' '.__('main.location')  }}">
            <option label="Label"></option>
            @foreach($locations as $location)
            <option
            value="{{$location->id}}" {{ ($action == 'edit') && $edit->location_id == $location->id ? 'selected' : '' }}>{{$location->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('location_id'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('location_id')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.latitude") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="latitude" type="number"  step="any" class="form-control {{$errors->has('latitude') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->latitude : old('latitude') }}"
               placeholder="{{ __("main.latitude") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('latitude'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('latitude')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.longitude") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="longitude" type="number" step="any" class="form-control {{$errors->has('longitude') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->longitude : old('longitude') }}"
               placeholder="{{ __("main.longitude") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('longitude'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('longitude')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">
        {{ __("main.branch-gallery") }}
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" multiple class="form-control {{$errors->has('branch-gallery') ? 'is-invalid':''}}" id="customFile" name="branch-gallery[]">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('branch-gallery'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('branch-gallery')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

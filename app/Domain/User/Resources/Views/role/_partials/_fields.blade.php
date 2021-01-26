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
    <div class="col-sm-12">
        <label class="col-form-label text-right col-lg-2 col-sm-12 mb-2">{{ __("main.permissions") }}</label>
    </div>
    @foreach($permissions as $permission => $value)
        <div class="col-md-4">
            <div class="checkbox-inline mb-5">
                <label class="checkbox checkbox-lg">
                    <input id="{{$permission}}" type="checkbox" value="{{$value}}"
                           {{$action == 'edit' && $value ?  "checked":""}} name="permissions[{{ $permission}}]">
                    <span></span>{{ $permission }}</label>
            </div>
        </div>
    @endforeach
</div>

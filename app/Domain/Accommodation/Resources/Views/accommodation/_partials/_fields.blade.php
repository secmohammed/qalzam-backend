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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.branch") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('branch_id') ? 'is-invalid':''}}" name="branch_id" data-placeholder="{{ __('main.select') .' '.__('main.branch')  }}">
            <option label="Label"></option>
            @foreach($branches as $branch)
            <option
            value="{{$branch->id}}" {{ ($action == 'edit') && $edit->branch_id == $branch->id ? 'selected' : '' }}>{{$branch->name}}</option>
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
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.type") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('type') ? 'is-invalid':''}}" name="type" data-placeholder="{{ __('main.select') .' '.__('main.type')  }}">
            <option label="Label"></option>
            <option
            value="room" {{ ($action == 'edit') && $edit->type == 'room' ? 'selected' : '' }}>Room</option>
            <option
            value="table" {{ ($action == 'edit') && $edit->type == 'table' ? 'selected' : '' }}>Table</option>
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.code") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="code" type="text"  class="form-control {{$errors->has('code') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->code : old('code') }}"
               placeholder="{{ __("main.code") }}">
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.price") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="price" type="number" step="any" class="form-control {{$errors->has('price') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->price : old('price') }}"
               placeholder="{{ __("main.price") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('price'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('price')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.capacity") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="capacity" type="number" step="any" class="form-control {{$errors->has('capacity') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->capacity : old('capacity') }}"
               placeholder="{{ __("main.capacity") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('capacity'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('capacity')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">
        {{ __("main.accommodation-gallery") }}
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" multiple class="form-control {{$errors->has('accommodation-gallery') ? 'is-invalid':''}}" id="customFile" name="accommodation-gallery[]">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('accommodation-gallery'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('accommodation-gallery')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

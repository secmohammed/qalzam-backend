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
    <label class="col-form-label text-right col-lg-2 col-sm-12">
        {{ __("main.name_ar") }} <span style="color: red"> * </span>
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="name_ar" type="text" class="form-control {{$errors->has('name_ar') ? 'is-invalid':''}}"
        value="{{ ($action == 'edit') ? $edit->getArAttribute('name') : old('name_ar') }}" placeholder="{{ __("main.name_ar") }}">
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.parent") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('parent_id') ? 'is-invalid':''}}" name="parent_id" data-placeholder="{{ __('main.select') .' '.__('main.parent')  }}">
            <option label="Label"></option>
            @foreach($categories as $category)
            <option
            value="{{$category->id}}" {{ ($action == 'edit') && $edit->parent_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
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
        {{ __("main.type") }}
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('type') ? 'is-invalid':''}}" name="type" data-placeholder="{{ __('main.select') .' '.__('main.type')  }}">
            <option label="Label" disabled></option>
            <option
            value="product" {{ ($action == 'edit') && $edit->type == 'product' ? 'selected' : '' }}>{{ __('main.product') }}</option>
            <option
            value="post" {{ ($action == 'edit') && $edit->type == 'post' ? 'selected' : '' }}>{{ __('main.post') }}</option>
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">
        {{ __("main.icon") }}
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" class="form-control {{$errors->has('icon') ? 'is-invalid':''}}" id="customFile" name="icon">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('icon'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('icon')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

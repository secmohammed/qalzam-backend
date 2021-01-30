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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.name_ar") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="name_ar" type="text" class="form-control {{$errors->has('name_ar') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? optional($edit->translations->first(), function ($translation) use ($edit) {
                    return $translation->where('translatable_id', $edit->id)->first()->value;
               }) ?? old('name_ar') : old('name_ar') }}" placeholder="{{ __("main.name_ar") }}">
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.slug") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text" name="slug" class="form-control {{$errors->has('slug') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->slug : old('slug') }}" placeholder="{{ __("main.slug") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('slug'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('slug')}}
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
        <input type="number" step="any" name="price" min="10" max="10000" class="form-control {{$errors->has('price') ? 'is-invalid':''}}"
               placeholder="{{ __("main.price") }}" />
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.description") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <textarea  name="description" class="form-control {{$errors->has('description') ? 'is-invalid':''}}"
               placeholder="{{ __("main.description") }}"></textarea>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('description'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('description')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.description") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <textarea name="description_ar" class="form-control {{$errors->has('description_ar') ? 'is-invalid':''}}"
               placeholder="{{ __("main.description") }}"></textarea>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('description_ar'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('description_ar')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.images") }}</label>

    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" name="product-images[]" multiple class="form-control {{$errors->has('product-images') ? 'is-invalid':''}}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('product-images'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('product-images')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

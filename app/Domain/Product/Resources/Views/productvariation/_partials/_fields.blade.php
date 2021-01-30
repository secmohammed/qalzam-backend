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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.product") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('product_id') ? 'is-invalid':''}}" name="product_id">
            <option label="Label"></option>
            @foreach($products as $product)
                <option
                    value="{{ $product->id }}" {{ ($action == 'edit') && $edit->product_id == $product->id ? 'selected' : '' }}>{{ $product->slug }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('product_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('product_id')}}
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.product_variation_type") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('product_variation_type_id') ? 'is-invalid':''}}" name="product_variation_type_id">
            <option label="Label"></option>
            @foreach($productVariationTypes as $productVariationType)
                <option
                    value="{{ $productVariationType->id }}" {{ ($action == 'edit') && $edit->product_variation_type_id == $productVariationType->id ? 'selected' : '' }}>{{ $productVariationType->name }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('product_variation_type_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('product_variation_type_id')}}
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.images") }}</label>

    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" name="product-variation-images[]" multiple class="form-control {{$errors->has('product-variation-images') ? 'is-invalid':''}}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('product-variation-images'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('product-variation-images')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

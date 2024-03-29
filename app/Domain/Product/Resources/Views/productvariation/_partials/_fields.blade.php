@foreach(config('app.available_locales') as $index => $lang)
    <x-form.name-field-by-lang  :lang="$lang" :action="$action" :edit="$edit??null"/>
@endforeach

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.product") }} <span
           style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('product_id') ? 'is-invalid':''}}" name="product_id">
            <option label="Label"></option>
            @foreach($products as $product)
                <option
                    value="{{ $product->id }}" {{ ($action == 'edit') && $edit->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
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
</>

<x-forms.status :action="$action"  :edit="$edit??null"/>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.slug") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text" name="slug" class="form-control {{$errors->has('slug') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit' && $edit->slug) ? $edit->slug : old('slug') }}" placeholder="{{ __("main.slug") }}">
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.slug_ar") }}  
        <span
        style="color: red"> * </span>
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text" name="slug_ar" class="form-control {{$errors->has('slug_ar') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit' && $edit->slug_ar) ? $edit->slug_ar : old('slug_ar') }}" placeholder="{{ __("main.slug_ar") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('slug_ar'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('slug_ar')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<x-forms.description :action="$action" :edit="$edit??null"/>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.description_ar") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <textarea  name="description_ar" class="form-control {{$errors->has('description_ar') ? 'is-invalid':''}}"
               placeholder="{{ __("main.description_ar") }}">
               {{ ($action == 'edit' && $edit->description_ar ) ? $edit->description_ar : old('description_ar') }}
            </textarea>
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


<x-forms.price :action="$action" :edit="$edit??null" />


<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.images") }}</label>

    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" name="product_variation-images[]" multiple class="form-control {{$errors->has('product_variation-images') ? 'is-invalid':''}}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('product_variation-images'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('product_variation-images')}}
                    </div>
                @endif
            </div>
            @if (  isset($edit)&&  $edit->getMediaCollectionUrl('product_variation-images')&& ($action == 'edit'))
            <div class="d-flex flex-row flex-row-wrap ">
                @foreach ($edit->getMediaCollectionUrl('product_variation-images') as $image)
                {{-- @dd($image) --}}
     <x-forms.small_image :image="$image"/>
     @endforeach
    </div>
    
    @endif
        </div>
    </div>
</div>

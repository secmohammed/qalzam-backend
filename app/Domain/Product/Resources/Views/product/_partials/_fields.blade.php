{{-- @dd($edit->getMediaCollectionUrl('product-images')) --}}
@foreach(config('app.available_locales') as $index => $lang)
    <x-form.name-field-by-lang  :lang="$lang" :action="$action" :edit="$edit??null"/>
@endforeach
<x-forms.status :action="$action"  :edit="$edit??null"/>

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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.slug_ar") }}  
        <span
        style="color: red"> * </span>
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="text" name="slug_ar" class="form-control {{$errors->has('slug_ar') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->slug_ar : old('slug_ar') }}" placeholder="{{ __("main.slug_ar") }}">
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

<x-forms.price :action="$action" :edit="$edit??null"/>

<x-forms.description :action="$action" :edit="$edit??null"/>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.description_ar") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <textarea  name="description_ar" class="form-control {{$errors->has('description_ar') ? 'is-invalid':''}}"
               placeholder="{{ __("main.description_ar") }}">
               {{ ($action == 'edit') ? $edit->description_ar : old('description_ar') }}
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
    <label class="col-form-label text-right col-lg-2 col-sm-12 ">{{ __("main.categories") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('categories') ? 'is-invalid':''}}"
                name="categories[]" multiple>
            <option label="Label"></option>

            @foreach($categories as $category)
                <option value="{{$category->id}}" {{ ($action == 'edit')  && $edit->categories->contains($category)  ? 'selected' : '' }}>{{$category->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('categories'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('categories')}}
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
@if (  isset($edit)&& $edit->getMediaCollectionUrl('product-images')&& ($action == 'edit'))
<div class="d-flex flex-row  flex-row-wrap">
@foreach ($edit->getMediaCollectionUrl('product-images') as $image)
{{-- @dd($image) --}}
 <x-forms.small_image :image="$image"/>
@endforeach
</div>

@endif
       
    </div>
</div>


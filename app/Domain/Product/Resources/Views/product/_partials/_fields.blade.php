
<x-forms.name :action="$action" :edit="$edit??null"/>
<x-forms.status :action="$action"  :edit="$edit??null"/>

<x-forms.ar_name :action="$action" :edit="$edit??null"/>


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
        {{-- {{ dd($edit->price  ) }} --}}
        <input type="number"    step="any" name="price" min="10" max="10000" class="form-control {{$errors->has('price') ? 'is-invalid':''}}"
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
<x-forms.description :action="$action" :edit="$edit??null"/>


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

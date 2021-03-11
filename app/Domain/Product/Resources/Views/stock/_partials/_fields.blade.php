<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.product_variation") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('product_variation_id') ? 'is-invalid':''}}" name="product_variation_id">
            <option label="Label"></option>
            @foreach($productVariations as $productVariation)
                <option
                    value="{{ $productVariation->id }}" {{ ($action == 'edit') && $edit->product_variation_id == $productVariation->id ? 'selected' : '' }}>{{ $productVariation->name }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('product_variation_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('product_variation_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<x-forms.status :action="$action"  :edit="$edit??null"/>


<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.quantity") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="number"  value="{{ $action == 'edit' ? (old('quantity') ?? $edit->quantity): old('quantity')}}" name="quantity" min="10" max="10000" class="form-control {{$errors->has('quantity') ? 'is-invalid':''}}"
               placeholder="{{ __("main.quantity") }}" />
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('quantity'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('quantity')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

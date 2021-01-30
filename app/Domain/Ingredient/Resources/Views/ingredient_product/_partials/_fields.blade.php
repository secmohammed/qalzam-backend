<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.product") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('products') ? 'is-invalid':''}}" name="products[]" multiple>
            <option label="Label"></option>
            @foreach ($products as $product)
                <option
                    value="{{ $product->id }}"}}> {{ $product->name }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('products'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('products')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

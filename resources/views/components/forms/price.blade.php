{{-- @dd($edit->price->amount()) --}}
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.price") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        {{-- {{ dd($edit->price  ) }} --}}
        <input type="number"    step="any" name="price" min="10" max="10000" class="form-control {{$errors->has('price') ? 'is-invalid':''}}"
               placeholder="{{ __("main.price") }}" 
               value="{{ ($action == 'edit') ? $edit->price->amount()/100 : old('price') }}"
               />
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
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.description") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <textarea  name="description" class="form-control {{$errors->has('description') ? 'is-invalid':''}}"
               placeholder="{{ __("main.description") }}">
               {{ ($action == 'edit') ? $edit->description : old('description') }}
            </textarea>
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
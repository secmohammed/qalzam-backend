<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.name$concatenate_trans") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="name{{$concatenate_trans}}" type="text" class="form-control {{$errors->has('name'. $concatenate_trans) ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $langFromModelValue : old('name'.$concatenate_trans) }}" placeholder="{{ __("main.name$concatenate_trans") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('name'.$concatenate_trans))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('name'.$concatenate_trans)}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->

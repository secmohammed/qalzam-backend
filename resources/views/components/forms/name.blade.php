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
  
    
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->

<div class="form-group row">
    <label  class="col-form-label text-right col-lg-2 col-sm-12">{{ __($label) }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input   class="form-control kt_timepicker_1 {{$errors->has($name) ? 'is-invalid':''}}"
       type="time" 
        id="example-time-input"
        name={{ $name }} 
        value="{{ $action == 'edit' ? $edit->$name : '13:45' }}">
        
        <div class="row">
            <div class="col-md-12">
                @if($errors->has($name))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first($name)}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

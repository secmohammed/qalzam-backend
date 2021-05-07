<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{__($label) }}  <span
            style="color: red"> * </span></label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has($name) ? 'is-invalid':''}}" name="{{ $name}}" {{ $multiple??"" }}>
            <option label="Label"></option>
                @for ($i = 0; $i < count(config("days.days")); $i++)
                <option value="{{  config('days.days')[$i] }}" {{ ($action == 'edit') && $edit->day == config('days.days')[$i] ? 'selected' : '' }}>{{  __('main.'. config('days.days')[$i]) }}</option>
                {{-- {{-- {{ dd(config("days")[0]) }} --}}
                @endfor


        </select>
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

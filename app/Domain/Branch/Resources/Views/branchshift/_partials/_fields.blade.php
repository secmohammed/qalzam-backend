<br>

<x-forms.day   :action="$action"  :edit="$edit??null" :name="'day'" label="main.day" />
<x-forms.status :action="$action"  :edit="$edit??null"/>



<div class="form-group row">
    <label  class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.start-time") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input   class="form-control kt_timepicker_1 {{$errors->has('start_time') ? 'is-invalid':''}}"
        name="start_time" type="time"
       id="example-time-input"
        value="{{ $action == 'edit' ? $edit->start_time : '13:45' }}">

        <div class="row">
            <div class="col-md-12">
                @if($errors->has('start_time'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('start_time')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label  class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.end-time") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input   class="form-control kt_timepicker_1 {{$errors->has('end_time') ? 'is-invalid':''}}"
       type="time"
        id="example-time-input"
        name="end_time"
        value="{{ $action == 'edit' ? $edit->end_time : '13:45' }}">

        <div class="row">
            <div class="col-md-12">
                @if($errors->has('end_time'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('end_time')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12 ">{{ __("main.branch") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('branch_id') ? 'is-invalid':''}}"
                name="branch_id">
            <option label="Label"></option>

            @foreach($branches as $branch)
                <option value="{{$branch->id}}" {{ ($action == 'edit')  && $edit->branch_id == $branch->id ? 'selected' : '' }}>{{$branch->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('branch_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('branch_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

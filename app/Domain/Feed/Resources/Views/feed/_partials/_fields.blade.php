<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.competition") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('competition_id') ? 'is-invalid':''}}" required name="competition_id">
            <option label="Label"></option>
            @foreach($competitions as $competition)
                <option value="{{ $competition->id }}" {{ ($action == 'edit') && $edit->competition_id == $competition->id ? 'selected' : '' }}>{{ $competition->name }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('competition_id'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('competition_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.children") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('child_id') ? 'is-invalid':''}}" name="child_id">
            <option label="Label"></option>
            @foreach($children as $child)
                <option value="{{ $child->id }}" {{ ($action == 'edit') && $edit->child_id == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('child_id'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('child_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row hidden">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.children") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('child_id') ? 'is-invalid':''}}" name="child_id">
            <option label="Label"></option>
            @foreach($children as $child)
                <option value="{{ $child->id }}" {{ ($action == 'edit') && $edit->child_id == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('child_id'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('child_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.status") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('status') ? 'is-invalid':''}}" name="status">
            <option label="Label"></option>
                <option
                    value="active" {{ ($action == 'edit') && $edit->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option
                    value="inactive" {{ ($action == 'edit') && $edit->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('status'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('status')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
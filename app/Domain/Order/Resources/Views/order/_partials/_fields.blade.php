<br>
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
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12 ">{{ __("main.discount") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('discount_id') ? 'is-invalid':''}}"
                name="discount_id">
            <option label="Label"></option>

            @foreach($discounts as $discount)
                <option value="{{$discount->id}}" {{ ($action == 'edit')  && $edit->discount_id == $discount->id ? 'selected' : '' }}>{{$discount->code}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('discount_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('discount_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12 ">{{ __("main.address") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('address_id') ? 'is-invalid':''}}"
                name="address_id">
            <option label="Label"></option>

            @foreach($addresses as $address)
                <option value="{{$address->id}}" {{ ($action == 'edit')  && $edit->address_id == $address->id ? 'selected' : '' }}>{{$address->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('address_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('address_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
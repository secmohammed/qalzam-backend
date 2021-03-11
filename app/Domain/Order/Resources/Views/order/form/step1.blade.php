{{-- @dd(1) --}}
<form action="">
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.address") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('address_id') ? 'is-invalid':''}}" name="address_id" data-placeholder="{{ __('main.select') .' '.__('main.address')  }}">
            <option label="Label"></option>
            @foreach($addresses as $address)
            <option
            value="{{$address->id}}" {{ ($action == 'edit') && $edit->address_id == $address->id ? 'selected' : '' }}>{{$address->name}}</option>
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
{{-- @dd(1) --}}
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.branch") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('branch_id') ? 'is-invalid':''}}" name="branch_id" data-placeholder="{{ __('main.select') .' '.__('main.branch')  }}">
            <option label="Label"></option>
            @foreach($branches as $branch)
            <option
            value="{{$branch->id}}" {{ ($action == 'edit') && $edit->branch_id == $branch->id ? 'selected' : '' }}>{{$branch->name}}</option>
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
{{-- @dd(1) --}}
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.user") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('user_id') ? 'is-invalid':''}}" name="user_id" data-placeholder="{{ __('main.select') .' '.__('main.user')  }}">
            <option label="Label"></option>
            @foreach($users as $user)
            <option
            value="{{$user->id}}" {{ ($action == 'edit') && $edit->user_id == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('user_id'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('user_id')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="d-flex justify-content-end mt-5">
    <button class="btn btn-primary " wire:click.prevent="submit" >
        {{__('main.next')}}  
    </button>

    
</div>
</form>
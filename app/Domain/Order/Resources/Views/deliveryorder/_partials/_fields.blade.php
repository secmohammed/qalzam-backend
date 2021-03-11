
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.order") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('order_id') ? 'is-invalid':''}}" name="order_id">
            <option label="Label"></option>
            @foreach ($orders as $order)
                
            <option
            value="{{ $order->id }}" {{ ($action == 'edit') && $edit->order == $order->id ? 'selected' : '' }}> #{{ $order->id }}       ( {{ $order->user->mobile }})</option>
          
            @endforeach  
                
                </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('order_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('order_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.branch") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('branch_id') ? 'is-invalid':''}}" name="branch_id">
            <option label="Label"></option>
            @foreach ($branches as $branch)
                
            <option
            value="{{ $branch->id }}" {{ ($action == 'edit') && $edit->branch == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
          
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
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.user") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('user_id') ? 'is-invalid':''}}" name="user_id">
            <option label="Label"></option>
            @foreach ($users as $user)
                
            <option
            value="{{ $user->id }}" {{ ($action == 'edit') && $edit->user == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
          
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
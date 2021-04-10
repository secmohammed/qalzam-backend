{{-- {{ dd($edit, $users ,$locations ) }} --}}
<br>
<x-forms.name :action="$action" :edit="$edit??null"/>


<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.branch-managers") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('user_id') ? 'is-invalid':''}}" name="user_id" data-placeholder="{{ __('main.select') .' '.__('main.branch-managers')  }}" >
            <option label="Label"></option>
            @foreach($branch_managers as $branch_maneg)
            <option
            value="{{$branch_maneg->id}}" {{ ($action == 'edit') && $edit->user_id === $branch_maneg->id  ? 'selected' : '' }}>{{$branch_maneg->name}} ({{ $branch_maneg->mobile }})</option>
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
<x-forms.status :action="$action" :edit="$edit??null"/>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.users") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('users') ? 'is-invalid':''}}" name="users[]" data-placeholder="{{ __('main.select') .' '.__('main.users')  }}" multiple>
            <option label="Label"></option>
            @foreach($users as $user)
            <option
            value="{{$user->id}}" {{ ($action == 'edit') && $selected_users->contains('id', $user->id)  ? 'selected' : '' }}>{{$user->name}} ({{ $user->mobile }})</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('users'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('users')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">

    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.deliverers") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('deliverers') ? 'is-invalid':''}}" name="deliverers[]" data-placeholder="{{ __('main.select') .' '.__('main.deliverers')  }}" multiple>
            <option label="Label"></option>
            @foreach($deliverers as $delivery)
            <option
            value="{{$delivery->id}}" {{ ($action == 'edit') && $selected_users->contains('id', $delivery->id)  ? 'selected' : '' }}>{{$delivery->name}} ({{ $delivery->mobile }})</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('deliverers'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('deliverers')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.location") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('location_id') ? 'is-invalid':''}}" name="location_id" data-placeholder="{{ __('main.select') .' '.__('main.location')  }}">
            <option label="Label"></option>
            @foreach($locations as $location)
            <option
            value="{{$location->id}}" {{ ($action == 'edit') && $edit->location_id == $location->id ? 'selected' : '' }}>{{$location->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('location_id'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('location_id')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.latitude") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="latitude" type="number"  step="any" class="form-control {{$errors->has('latitude') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->latitude : old('latitude') }}"
               placeholder="{{ __("main.latitude") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('latitude'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('latitude')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.delivery_fee") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="delivery_fee" type="number" step="any" class="form-control {{$errors->has('delivery_fee') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->delivery_fee : old('delivery_fee') }}"
               placeholder="{{ __("main.delivery_fee") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('delivery_fee'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('delivery_fee')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.longitude") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="longitude" type="number" step="any" class="form-control {{$errors->has('longitude') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->longitude : old('longitude') }}"
               placeholder="{{ __("main.longitude") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('longitude'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('longitude')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.address_1") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="address_1" type="text"  class="form-control {{$errors->has('address_1') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->address_1 : old('address_1') }}"
               placeholder="{{ __("main.address_1") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('address_1'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('address_1')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">
        {{ __("main.branch-gallery") }}
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" multiple class="form-control {{$errors->has('branch-gallery') ? 'is-invalid':''}}" id="customFile" name="branch-gallery[]">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('branch-gallery'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('branch-gallery')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-timepicker.js') }}"></script>
@endpush

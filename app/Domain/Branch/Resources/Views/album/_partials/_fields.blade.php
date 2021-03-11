<br>
<x-forms.name :action="$action" :edit="$edit??null"/>


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

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">
        {{ __("main.album-gallery") }}
    </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" multiple class="form-control {{$errors->has('album-gallery') ? 'is-invalid':''}}" id="customFile" name="album-gallery[]">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('album-gallery'))
                <div class="alert alert-danger w-100 m-0" role="alert">
                    {{$errors->first('album-gallery')}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-timepicker.js') }}"></script>
@endpush

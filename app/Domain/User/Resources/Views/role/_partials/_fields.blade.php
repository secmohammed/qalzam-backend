<x-forms.name :action="$action" :edit="$edit??null"/>


<div class="form-group row">
    <div class="col-sm-12">
        <label class="col-form-label text-right col-lg-2 col-sm-12 mb-2">{{ __("main.permissions") }}</label>
    </div>
    @foreach($permissions as $permission => $value)
        <div class="col-md-4">
            <div class="checkbox-inline mb-5">
                <label class="checkbox checkbox-lg">
                    <input id="{{$permission}}" type="checkbox" value="{{$value}}"
                           {{$action == 'edit' && $value ?  "checked":""}} name="permissions[{{ $permission}}]">
                    <span></span>{{ $permission }}</label>
            </div>
        </div>
    @endforeach
</div>

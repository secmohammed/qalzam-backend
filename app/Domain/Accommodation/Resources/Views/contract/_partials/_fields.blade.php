<br>
<x-forms.name :action="$action" :edit="$edit??null"/>


<x-forms.status :action="$action" :edit="$edit??null"/>
<x-forms.days   :action="$action"  :edit="$edit??null" :multiple="'multiple'" :name="'days[]'" label="main.days" />

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12 ">{{ __("main.template") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('template_id') ? 'is-invalid':''}}"
                name="template_id">
            <option label="Label"></option>

            @foreach($templates as $template)
                <option value="{{$template->id}}" {{ ($action == 'edit')  && $edit->template_id == $template->id ? 'selected' : '' }}>{{$template->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('template_id'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('template_id')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>




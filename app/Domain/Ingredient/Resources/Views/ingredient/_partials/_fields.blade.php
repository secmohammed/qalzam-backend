<x-forms.name :action="$action" :edit="$edit??null"/>

<x-forms.ar_name :action="$action" :edit="$edit??null"/>
<x-forms.description :action="$action" :edit="$edit??null"/>


<x-forms.status :action="$action"  :edit="$edit??null"/>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.image") }}</label>

    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" name="ingredient-icon" class="form-control {{$errors->has('ingredient-icon') ? 'is-invalid':''}}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('ingredient-icon'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('ingredient-icon')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

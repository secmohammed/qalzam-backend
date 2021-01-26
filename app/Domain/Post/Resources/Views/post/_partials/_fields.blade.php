<br>
<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.title_en") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="title" type="text" class="form-control {{$errors->has('title') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->title : old('title') }}" placeholder="{{ __("main.title_en") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('title'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('title')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.title_ar") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <input name="title_ar" type="text" class="form-control {{$errors->has('title_ar') ? 'is-invalid':''}}"
               value="{{ ($action == 'edit') ? $edit->getArAttribute('title') : old('title_ar') }}" placeholder="{{ __("main.title_ar") }}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('title_ar'))
                    <div class="alert alert-danger w-100 m-0" type="alert">
                        {{$errors->first('title_ar')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.description") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <textarea  name="description" class="form-control {{$errors->has('description') ? 'is-invalid':''}}" cols="30"
                  rows="6" data-provide="markdown"
                  placeholder="{{ __("main.description") }}">{{ ($action == 'edit') ? $edit->description : old('description') }}</textarea>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('description'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('description')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.description_ar") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <textarea name="description_ar" data-provide="markdown" class="form-control {{$errors->has('description_ar') ? 'is-invalid':''}}"
                  cols="30" rows="6"
                  placeholder="{{ __("main.description_ar") }}">{{ ($action == 'edit') ? $edit->getArAttribute('description')  : old('description_ar') }}</textarea>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('description_ar'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('description_ar')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.status") }} <span
            style="color: red"> * </span> </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('status') ? 'is-invalid':''}}" name="status" data-placeholder="{{ __('main.select').' '.__('main.status') }}">
            <option label="Label"></option>
            <option
                value="approved" {{ ($action == 'edit') && $edit->status == 'approved' ? 'selected' : '' }}>{{ __('main.approved') }}</option>
            <option
                value="disapproved" {{ ($action == 'edit') && $edit->status == 'disapproved' ? 'selected' : '' }}>{{ __('main.disapproved') }}</option>
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

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.type") }} </label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('type') ? 'is-invalid':''}}" name="type" data-placeholder="{{ __('main.select').' '.__('main.type') }}">
            <option label="Label"></option>
            <option value="normal" {{ ($action == 'edit') && $edit->type == 'normal' ? 'selected' : '' }}>{{ __('main.normal') }}</option>
            <option value="featured" {{ ($action == 'edit') && $edit->type == 'featured' ? 'selected' : '' }}>{{ __('main.featured') }}</option>
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('type'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('type')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12 ">{{ __("main.categories") }}</label>
    <div class="col-lg-10 col-md-9 col-sm-12">
        <select class="form-control select2 {{$errors->has('categories') ? 'is-invalid':''}}" multiple
                name="categories[]" data-placeholder="{{ __('main.select').' '.__('main.category') }}">
            <option label="Label"></option>

            @foreach($categories as $category)
                <option value="{{$category->id}}" {{ ($action == 'edit')  && in_array($category->id, $edit->categories->pluck('id')->toArray()) ? 'selected' : '' }}>{{$category->name}}</option>
            @endforeach
        </select>
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('categories'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('categories')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-form-label text-right col-lg-2 col-sm-12">{{ __("main.image") }}</label>

    <div class="col-lg-10 col-md-9 col-sm-12">
        <input type="file" name="image" class="form-control {{$errors->has('image') ? 'is-invalid':''}}">
        <div class="row">
            <div class="col-md-12">
                @if($errors->has('image'))
                    <div class="alert alert-danger w-100 m-0" role="alert">
                        {{$errors->first('image')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    "use strict";
    // Class definition

    var KTBootstrapMarkdown = function () {
        // Private functions
        var demos = function () {

        }

        return {
            // public functions
            init: function() {
                demos();
            }
        };
    }();

    // Initialization
    jQuery(document).ready(function() {
        KTBootstrapMarkdown.init();
    });
</script>

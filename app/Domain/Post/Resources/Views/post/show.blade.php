@extends('theme.app')

@push('styles')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.8.3/css/lg-fb-comment-box.min.css"
          integrity="sha512-vYu0Nd+ml6fhXHO671nhVS/c/puVD65iw4sJNw3j2zrH/q0i7pOIz9eoTZC3bxyRzYQfidejBbLcjJJMksYYpg=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.8.3/css/lg-transitions.min.css"
          integrity="sha512-/kdQdrZJ0rc181QhzXU6oIknhyr5NIuZlv4VzvhdDsiEzEbW9mckFGTqat8CM8FlGDCHMMUYity1gXIgjHJ58A=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.8.3/css/lightgallery.min.css"
          integrity="sha512-gk6oCFFexhboh5r/6fov3zqTCA2plJ+uIoUx941tQSFg6TNYahuvh1esZVV0kkK+i5Kl74jPmNJTTaHAovWIhw=="
          crossorigin="anonymous"/>
@endpush

@section('content')

    <div class="subheader py-2 py-lg-6  subheader-transparent" id="kt_subheader">
        <div class="container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Mobile Toggle-->
                <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none"
                        id="kt_subheader_mobile_toggle">
                    <span></span>
                </button>
                <!--end::Mobile Toggle-->

                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class=" text-dark font-weight-bold my-1 mr-5 {{ GetLanguage() == 'ar' ? 'ml-2' : '' }}">
                        {{ __('main.show') }} {{ __('main.post') }} </h5>
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-muted">
                                {{ __('main.home') }} </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('posts.index') }}" class="text-muted">
                                {{ __('main.posts') }} </a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->

        </div>
    </div>

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Todo-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('main.show') }} {{ __('main.post') }} : # {{ $post->slug }}
                            </h3>
                            <div class="card-toolbar">
                                <a title="{{ __('main.create') }} {{ __('main.post') }}"
                                   href="{{ route('posts.create') }}"
                                   class="btn btn-light-primary font-weight-bolder mr-2">
                                    <i class="flaticon2-plus"
                                       style="color: #FFF"></i> {{ __("main.add") }} {{ __("main.post") }} </a>
                                <a title="{{ __('main.delete') }} {{ __('main.post') }}"
                                   href="{{ route('posts.destroy', $post->id) }}"
                                   class="btn btn-light-danger font-weight-bolder mr-2" data-toggle="modal"
                                   data-target="#delete_{{$post->id}}">
                                    <i class="flaticon2-trash"></i> {{ __("main.delete") }} {{ __("main.post") }}
                                </a>
                                <a title="{{ __('main.edit') }} {{ __('main.post') }}"
                                   href="{{ route('posts.edit', $post->slug) }}"
                                   class="btn btn-light-warning font-weight-bolder mr-2">
                                    <i class="flaticon2-edit"></i> {{ __("main.edit") }} {{ __("main.post") }} </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class="ml-3"><span>{{ __("main.name") }} : </span></strong>
                                        <span>{{ $post->title ?? 'N/A' }} </span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.type") }} : </span></strong>
                                        <span>{{$post->type ? __("main.{$post->type}") : 'N/A'}}</span>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.status") }} : </span></strong>
                                        <span>{{$post->status ? __("main.{$post->status}") : 'N/A'}}</span>
                                    </div>
                                    <hr>
                                </div>

                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.categories") }} : </span></strong>
                                        @if($post->categories->count())
                                            @foreach($post->categories as $category)
                                                <span class="mr-1">{{$category->name ?? "N/A"}} @if(!$loop->last)
                                                        , @endif</span>
                                            @endforeach
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.created_at") }} : </span></strong>
                                        <span>{{$post->created_at}}</span>
                                    </div>
                                    <hr>
                                </div>

                                <div class="col-md-6 mb-5"></div>

                                <div class="col-md-6 mb-5">
                                    <div class="row mb-2">
                                        <strong class='ml-3'><span>{{ __("main.description") }} : </span></strong>
                                        <span class="w-400px">{{$post->description ?? 'N/A'}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <strong class='ml-3'><span>{{ __("main.image") }} : </span></strong>
                                        <div id="lightgallery2">
                                            @if($post->getMedia('image')->count())
                                                <div data-src="{{ $post->getFirstMedia('image')->getUrl() }}">
                                                    <a href="{{ $post->getFirstMedia('image')->getUrl() }}">
                                                        <img class="d-block" src="{{ $post->getFirstMedia('image')->getUrl() }}"
                                                             style="width:100%" alt="image">
                                                    </a>
                                                </div>
                                            @else
                                                N/A
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="delete_{{$post->id}}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('main.delete') }} {{ __('main.post') }}
                        : {{ __('main.posts') }} #({{ $post->name }})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <div class="modal-body">
                        {{ __('main.delete') }} {{ __('main.posts') }}: {{ __('main.posts') }}
                        #({{ $post->name }})
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('main.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('main.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.8.3/js/lightgallery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#lightgallery, #lightgallery2").lightGallery();
        });
    </script>
@endpush

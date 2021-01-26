@extends('layouts.layout')
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
            @if(GetLanguage() == 'ar')
            <style>
            .lg-outer {
            direction: ltr;
            }
            </style>
            @endif
            @endpush
            @section('content')
            <div class="subheader py-2 py-lg-6  subheader-transparent " id="kt_subheader">
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
                            {{ __('main.show') }} {{ __('main.competition') }} </h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}" class="text-muted">
                                    {{ __('main.home') }} </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('competitions.index') }}" class="text-muted">
                                    {{ __('main.competitions') }} </a>
                                </li>
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page Heading-->
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <div class="row">
                <!--begin::Entry-->
                <div class="col-xl-8">
                    <!--begin::Container-->
                    <div class="container-fluid">
                        <!--begin::Todo-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-custom">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                        {{ __('main.show') }} {{ __('main.competition') }} : # {{ $show->id }}
                                        </h3>
                                        <div class="card-toolbar">
                                            <a title="{{ __('main.create') }} {{ __('main.competition') }}"
                                                href="{{ route('competitions.create') }}"
                                                class="btn btn-light-primary font-weight-bolder mr-2">
                                                <i class="flaticon2-plus"
                                            style="color: #FFF"></i> {{ __("main.add") }} {{ __("main.competition") }} </a>
                                            <a title="{{ __('main.delete') }} {{ __('main.competition') }}"
                                                href="{{ route('competitions.destroy', $show->id) }}"
                                                class="btn btn-light-danger font-weight-bolder mr-2" data-toggle="modal"
                                                data-target="#delete_{{$show->id}}">
                                            <i class="flaticon2-trash"></i> {{ __("main.delete") }} {{ __("main.competition") }} </a>
                                            <a title="{{ __('main.edit') }} {{ __('main.competition') }}"
                                                href="{{ route('competitions.edit', $show->id) }}"
                                                class="btn btn-light-warning font-weight-bolder mr-2">
                                            <i class="flaticon2-edit"></i> {{ __("main.edit") }} {{ __("main.competition") }} </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-5">
                                                <div class="row mb-2">
                                                    <strong class='ml-3'><span>{{ __("main.name") }} : </span></strong>
                                                    <span>{{ $show->name ?? 'N/A' }} </span>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-6 mb-5">
                                                <div class="row mb-2">
                                                    <strong class='ml-3'><span>{{ __("main.start_date") }} : </span></strong>
                                                    <span>{{ $show->start_date ?? 'N/A' }} </span>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-6 mb-5">
                                                <div class="row mb-2">
                                                    <strong class='ml-3'><span>{{ __("main.end_date") }} : </span></strong>
                                                    <span>{{ $show->end_date ?? 'N/A' }} </span>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-6 mb-5">
                                                <div class="row mb-2">
                                                    <strong class='ml-3'><span>{{ __("main.age") }} : </span></strong>
                                                    <span>{{ $show->min_age  }} - {{ $show->max_age}} </span>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-6 mb-5">
                                                <div class="row mb-2">
                                                    <strong class='ml-3'><span>{{ __("main.location") }} : </span></strong>
                                                    <span>{{ $show->location->name  }}  </span>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-6 mb-5">
                                                <div class="row mb-2">
                                                    <strong class='ml-3'><span>{{ __("main.featured") }} : </span></strong>
                                                    <span>{{ $show->featured  }}  </span>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-6 mb-5">
                                                <div class="row mb-2">
                                                    <strong class='ml-3'><span>{{ __("main.type") }} : </span></strong>
                                                    <span>{{ $show->type ? __("main.{$show->type}") : 'N/A' }} </span>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-6 mb-5">
                                                <div class="row mb-2">
                                                    <strong class='ml-3'><span>{{ __("main.created_at") }} : </span></strong>
                                                    <span>{{$show->created_at}}</span>
                                                </div>
                                                <hr>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="col-md-12">
                                                <div class="row mb-2">
                                                    <strong class='ml-3'><span>{{ __("main.image") }} : </span></strong>
                                                    @if($show->getFirstMedia('competition-cover'))
                                                    <div id="lightgallery">
                                                        <div data-src="{{ $show->getFirstMedia('competition-cover')->getUrl() }}">
                                                            <a href="{{ $show->getFirstMedia('competition-cover')->getUrl() }}">
                                                                <img class="d-block" src="{{ $show->getFirstMedia('competition-cover')->getUrl() }}"
                                                                style="width:100%" alt="...">
                                                            </a>
                                                        </div>
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
                <div class="col-xl-4" wfd-id="686">
                    <!--begin::List Widget 2-->
                    <div class="card card-custom bg-light-success gutter-b card-stretch card-shadowless" wfd-id="687">
                        <!--begin::Header-->
                        <div class="card-header border-0" wfd-id="714">
                            <h3 class="card-title font-weight-bolder text-success">Participants ({{ $show->children->count() }})</h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2" wfd-id="688">
                            <!--begin::Item-->
                            @foreach($show->children as $child)
                            <div class="d-flex align-items-center mb-10" wfd-id="709">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40 symbol-light-white mr-5" wfd-id="712">
                                    <div class="symbol-label" wfd-id="713">
                                        <img src="{{ $child->getFirstMediaUrl('child-avatar')}}" class="h-75 align-self-end" alt="">
                                    </div>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column font-weight-bold" wfd-id="710">
                                    <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">{{ $child->name }} </a>
                                    <span class="text-muted" wfd-id="711">{{ now()->diffInYears($child->birthdate) }} Years Old</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            @endforeach
                            <!--end::Item-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::List Widget 2-->
                </div>
            </div>
            @foreach($show->feeds as $feed)
            <div class="d-flex flex-column-fluid">
                <div class="card-body" wfd-id="345">
                    <!--begin::Container-->
                    <div wfd-id="351">
                        <!--begin::Header-->
                        <div class="d-flex align-items-center pb-4" wfd-id="372">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40 symbol-light-success mr-5" wfd-id="377">
                                <span class="symbol-label" wfd-id="378">
                                    <img src="{{ $feed->child->getFirstMediaUrl('child-avatar')}}" class="h-75 align-self-end" alt="">
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Info-->
                            <div class="d-flex flex-column flex-grow-1" wfd-id="375">
                                <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">{{ $feed->child->name }} </a>
                                <span class="text-muted font-weight-bold" wfd-id="376">{{ $feed->created_at->toDateTimeString()}}</span>
                            </div>
                            <!--end::Info-->
                            <!--begin::Dropdown-->
                            <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions" wfd-id="373">
                                <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right" wfd-id="374" style="">
                                    <!--begin::Navigation-->
                                    <ul class="navi navi-hover">
                                        <li class="navi-header font-weight-bold py-4">
                                            <span class="font-size-lg">Actions:</span>
                                        </li>
                                        <li class="navi-separator mb-3 opacity-70"></li>
                                        <li class="navi-item">
                                            <a href="{{ route('feeds.show', $feed->id)}}" class="navi-link">
                                                <span class="navi-text">
                                                    <span class="label label-xl label-inline label-light-success">Show</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="{{ route('feeds.edit', $feed->id)}}" class="navi-link">
                                                <span class="navi-text">
                                                    <span class="label label-xl label-inline label-light-danger">Edit</span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Navigation-->
                                </div>
                            </div>
                            <!--end::Dropdown-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div wfd-id="352">
                            <!--begin::Text-->
                            <p class="text-dark-75 font-size-lg font-weight-normal">{{ $feed->description }} </p>
                            @foreach($feed->getMediaCollectionUrl('feed-isomorphic') as $media)
                            @if($feed->competition->type == 'image')
                            <div class="bgi-no-repeat bgi-size-cover rounded min-h-265px" style="background-image: url({{ $media }})" wfd-id="390"></div>
                            @elseif($feed->competition->type == 'video')
                            <video wfd-id="390" class="bgi-no-repeat bgi-size-cover rounded min-h-265px" src="{{ $media }}"/>
                                @else
                                <p class="text-dark-75 font-size-lg font-weight-normal">{{ $feed->checked_in_location }} </p>
                                @endif
                                @endforeach
                                <!--end::Text-->
                                <!--begin::Action-->
                                <div class="d-flex align-items-center" wfd-id="369">
                                    <a href="#" class="btn btn-hover-text-primary btn-hover-icon-primary btn-sm btn-text-dark-50 bg-light-primary rounded font-weight-bolder font-size-sm p-2 mr-2">
                                        <span class="svg-icon svg-icon-md svg-icon-primary pr-2" wfd-id="371">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo2/dist/assets/media/svg/icons/Communication/Group-chat.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000"></path>
                                            <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>{{ $feed->comments_count }} </a>
                                <a href="#" class="btn btn-hover-text-danger btn-hover-icon-danger btn-sm btn-text-dark-50 bg-hover-light-danger rounded font-weight-bolder font-size-sm p-2">
                                    <span class="svg-icon svg-icon-md svg-icon-dark-25 pr-1" wfd-id="370">
                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo2/dist/assets/media/svg/icons/General/Heart.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                        <path d="M16.5,4.5 C14.8905,4.5 13.00825,6.32463215 12,7.5 C10.99175,6.32463215 9.1095,4.5 7.5,4.5 C4.651,4.5 3,6.72217984 3,9.55040872 C3,12.6834696 6,16 12,19.5 C18,16 21,12.75 21,9.75 C21,6.92177112 19.349,4.5 16.5,4.5 Z" fill="#000000" fill-rule="nonzero"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>{{ $feed->reviews_count }} </a>
                        </div>
                        <!--end::Action-->
                        <!--begin::Item-->
                        <!--end::Item-->
                        <!--begin::Item-->
                        @foreach($feed->comments as $comment)
                        <div class="d-flex" wfd-id="353">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40 symbol-light-success mr-5 mt-1" wfd-id="359">
                                <span class="symbol-label" wfd-id="360">
                                    <img src="{{ $comment->user->getFirstMediaUrl('avatar')}}" class="h-75 align-self-end" alt="">
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Info-->
                            <div class="d-flex flex-column flex-row-fluid" wfd-id="354">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center flex-wrap" wfd-id="356">
                                    <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder pr-6">{{ $comment->user->name }} </a>
                                    <span class="text-muted font-weight-normal flex-grow-1 font-size-sm" wfd-id="358">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="text-dark-75 font-size-sm font-weight-normal pt-1" wfd-id="355">{{ $comment->body }}</span>
                                <!--end::Info-->
                            </div>
                            <!--end::Info-->
                        </div>
                        @endforeach
                        <!--end::Item-->
                    </div>
                    <div class="separator separator-solid mt-5 mb-4" wfd-id="350"></div>
                </div>
            </div>
        </div>
        @endforeach
        <!--end::Body-->
        <!--end::Container-->
        <!--begin::Separator-->
        <!--end::Separator-->
    </div>
</div>
<div class="modal fade" id="delete_{{$show->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('main.delete') }} {{ __('main.competition') }}
                : {{ __('main.competitions') }} #({{ $show->name }})</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="{{ route('competitions.destroy', $show->id) }}" method="post">
                @csrf
                @method("DELETE")
                <div class="modal-body">
                    {{ __('main.delete') }} {{ __('main.competitions') }}: {{ __('main.competitions') }} #({{ $show->name }})
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
$("#lightgallery").lightGallery();
});
</script>
@endpush

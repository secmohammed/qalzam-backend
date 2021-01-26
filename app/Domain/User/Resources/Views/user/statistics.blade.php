@extends('layouts.layout')

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
            {{--                            <div class="d-flex align-items-baseline flex-wrap mr-5">--}}
            <!--end::Mobile Toggle-->
                <!--begin::Entry-->
                <div class="d-flex flex-column">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Todo-->
                        <div class="row">
                            <div class="col-xl-4">
                                <!--begin: Stats Widget 19-->
                                <div
                                    class="card card-custom btn-light-primary card-stretch gutter-b bg-white">
                                    <!--begin::Body-->
                                    <div class="card-body my-3">
                                        <div
                                            class="card-title font-weight-bolder  text-hover-state-dark font-size-h6 mb-4 d-block">{{ __("main.number_of_meetings") }}</div>
                                        <div class="font-weight-bold text-muted font-size-sm">
                        <span
                            class="text-dark-75 font-size-h2 font-weight-bolder mr-2">{{auth()->user()->meetings->count()}}</span>{{ __("main.meeting") }}
                                        </div>
                                    </div>
                                    <!--end:: Body-->
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <!--begin: Stats Widget 19-->
                                <div
                                    class="card card-custom btn-light-primary card-stretch gutter-b bg-white">
                                    <!--begin::Body-->
                                    <div class="card-body my-3">
                                        <div
                                            class="card-title font-weight-bolder  text-hover-state-dark font-size-h6 mb-4 d-block">{{ __("main.number_of_stores") }}</div>
                                        <div class="font-weight-bold text-muted font-size-sm">
                        <span
                            class="text-dark-75 font-size-h2 font-weight-bolder mr-2">{{\App\Domain\Store\Entities\Store::where('user_id',auth()->id())->count()}}</span>{{ __("main.store") }}
                                        </div>
                                    </div>
                                    <!--end:: Body-->
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <!--begin: Stats Widget 19-->
                                <div
                                    class="card card-custom btn-light-primary card-stretch gutter-b bg-white">
                                    <!--begin::Body-->
                                    <div class="card-body my-3">
                                        <div
                                            class="card-title font-weight-bolder  text-hover-state-dark font-size-h6 mb-4 d-block">{{ __("main.number_of_products") }}</div>
                                        <div class="font-weight-bold text-muted font-size-sm">
                        <span
                            class="text-dark-75 font-size-h2 font-weight-bolder mr-2">{{\App\Domain\Product\Entities\Product::where('user_id',auth()->id())->count()}}</span>{{ __("main.product") }}
                                        </div>
                                    </div>
                                    <!--end:: Body-->
                                </div>
                            </div>
                            <!--end: Stats:Widget 19-->
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <!--begin::Advance Table Widget 2-->
                                <div class="card card-custom gutter-b card-stretch card-shadowless bg-white">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label font-weight-bolder text-dark">{{__('main.new_meetings')}}</span>
                                            {{--                                            <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span>--}}
                                        </h3>
                                        <div class="card-toolbar">
                                            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                                {{--                                                <li class="nav-item">--}}
                                                {{--                                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_11_1">Month</a>--}}
                                                {{--                                                </li>--}}
                                                {{--                                                <li class="nav-item">--}}
                                                {{--                                                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_tab_pane_11_2">Week</a>--}}
                                                {{--                                                </li>--}}
                                                <li class="nav-item">
                                                    <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_tab_pane_11_3">{{__('main.today')}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-2 pb-0 mt-n3">
                                        <div class="tab-content mt-5" id="myTabTables11">
                                            <!--begin::Tap pane-->

                                            <div class="tab-pane fade show active" id="kt_tab_pane_11_3" role="tabpanel" aria-labelledby="kt_tab_pane_11_3">
                                                <!--begin::Table-->
                                                <div class="table-responsive">
                                                    <table class="table table-borderless table-vertical-center">
                                                        <thead>
                                                        <tr>
                                                            <th class="p-0 w-40px"></th>
                                                            <th class="p-0 min-w-200px"></th>
                                                            <th class="p-0 min-w-150px"></th>
                                                            <th class="p-0 min-w-200px"></th>
                                                            <th class="p-0 min-w-110px"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach(auth()->user()->meetings->whereBetween('start_date',[\Carbon\Carbon::today(),\Carbon\Carbon::tomorrow()])->all() as $meeting)
                                                            <tr>
                                                                <td class="pl-0 py-4">
                                                                    <div class="symbol symbol-50 symbol-light mr-1">
																				<span class="symbol-label">
																					<img src="{{asset('assets/media/svg/misc/015-telegram.svg')}}" class="h-50 align-self-center" alt="">
																				</span>
                                                                    </div>
                                                                </td>
                                                                <td class="pl-0">
                                                                    <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$meeting->user->name}}</a>
                                                                    <div>
                                                                        <span class="font-weight-bolder">Email:</span>
                                                                        <a class="text-muted font-weight-bold text-hover-primary" href="#">{{$meeting->user->email}}</a>
                                                                    </div>
                                                                </td>
                                                                <td class="text-right">
                                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$meeting->store->name}}</span>
                                                                    <span class="text-muted font-weight-bold">{{$meeting->start_date}}</span>
                                                                </td>
                                                                <td class="text-right">
                                                                    <span class="text-muted font-weight-500">{{$meeting->description}}</span>
                                                                </td>
                                                                <td class="text-right">
                                                                    <span class="label label-lg label-light-primary label-inline">{{$meeting->status}}</span>
                                                                </td>
                                                                {{--                                                            <td class="text-right pr-0">--}}
                                                                {{--                                                                <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">--}}
                                                                {{--																				<span class="svg-icon svg-icon-md svg-icon-primary">--}}
                                                                {{--																					<!--begin::Svg Icon | path:/metronic/theme/html/demo5/dist/assets/media/svg/icons/General/Settings-1.svg-->--}}
                                                                {{--																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
                                                                {{--																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
                                                                {{--																							<rect x="0" y="0" width="24" height="24"></rect>--}}
                                                                {{--																							<path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"></path>--}}
                                                                {{--																							<path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"></path>--}}
                                                                {{--																						</g>--}}
                                                                {{--																					</svg>--}}
                                                                {{--                                                                                    <!--end::Svg Icon-->--}}
                                                                {{--																				</span>--}}
                                                                {{--                                                                </a>--}}
                                                                {{--                                                                <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">--}}
                                                                {{--																				<span class="svg-icon svg-icon-md svg-icon-primary">--}}
                                                                {{--																					<!--begin::Svg Icon | path:/metronic/theme/html/demo5/dist/assets/media/svg/icons/Communication/Write.svg-->--}}
                                                                {{--																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
                                                                {{--																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
                                                                {{--																							<rect x="0" y="0" width="24" height="24"></rect>--}}
                                                                {{--																							<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>--}}
                                                                {{--																							<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>--}}
                                                                {{--																						</g>--}}
                                                                {{--																					</svg>--}}
                                                                {{--                                                                                    <!--end::Svg Icon-->--}}
                                                                {{--																				</span>--}}
                                                                {{--                                                                </a>--}}
                                                                {{--                                                                <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">--}}
                                                                {{--																				<span class="svg-icon svg-icon-md svg-icon-primary">--}}
                                                                {{--																					<!--begin::Svg Icon | path:/metronic/theme/html/demo5/dist/assets/media/svg/icons/General/Trash.svg-->--}}
                                                                {{--																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">--}}
                                                                {{--																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
                                                                {{--																							<rect x="0" y="0" width="24" height="24"></rect>--}}
                                                                {{--																							<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>--}}
                                                                {{--																							<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>--}}
                                                                {{--																						</g>--}}
                                                                {{--																					</svg>--}}
                                                                {{--                                                                                    <!--end::Svg Icon-->--}}
                                                                {{--																				</span>--}}
                                                                {{--                                                                </a>--}}
                                                                {{--                                                            </td>--}}
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Tap pane-->
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Advance Table Widget 2-->
                            </div>
                        </div>
                    </div>
                </div>

                <!--begin::Page Heading-->
                {{--                <div class="d-flex align-items-baseline flex-wrap mr-5">--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>

@endsection

<!--begin::Header-->
<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container d-flex align-items-stretch justify-content-between">
        <!--begin::Left-->
        <div class="d-none d-lg-flex align-items-center mr-3">
            <!--begin::Aside Toggle-->
            <button class="btn btn-icon aside-toggle ml-n3 mr-10" id="kt_aside_desktop_toggle">
                                    <span class="svg-icon svg-icon-xxl svg-icon-dark-75">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Text/Align-left.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2" rx="1" />
                                                <rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2" rx="1" />
                                                <path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z" fill="#000000" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
            </button>
            <!--end::Aside Toggle-->
            <!--begin::Logo-->
            <a href="{{ route('dashboard') }}">
<img alt="Logo" src="{{ asset('assets/images/qalzam-logo.svg') }}" class="logo-sticky max-h-45px"/>
            </a>
            <!--end::Logo-->
        </div>
        <!--end::Left-->
        <!--begin::Topbar-->
        <div class="topbar">
            <!--begin::Tablet & Mobile Search-->
            <div class="dropdown d-flex d-lg-none">
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
                                            <span class="svg-icon svg-icon-xl">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                    </div>
                </div>
                <!--end::Toggle-->
                <!--begin::Dropdown-->

                <!--end::Dropdown-->
            </div>
            <!--end::Tablet & Mobile Search-->
            <!--begin::Create-->
{{--            <div class="dropdown">--}}
{{--                <!--begin::Toggle-->--}}
{{--                <div class="topbar-item mr-4" data-toggle="dropdown" data-offset="10px,0px">--}}
{{--                    <div class="btn font-weight-bolder btn-sm btn-light-success px-5">Create</div>--}}
{{--                </div>--}}
{{--                <!--end::Toggle-->--}}
{{--                <!--begin::Dropdown-->--}}
{{--                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-md">--}}
{{--                    <!--begin::Navigation-->--}}
{{--                    <ul class="navi navi-hover py-5">--}}
{{--                        <li class="navi-item">--}}
{{--                            <a href="#" class="navi-link">--}}
{{--                                                    <span class="navi-icon">--}}
{{--                                                        <i class="flaticon2-drop"></i>--}}
{{--                                                    </span>--}}
{{--                                <span class="navi-text">New Group</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="navi-item">--}}
{{--                            <a href="#" class="navi-link">--}}
{{--                                                    <span class="navi-icon">--}}
{{--                                                        <i class="flaticon2-list-3"></i>--}}
{{--                                                    </span>--}}
{{--                                <span class="navi-text">Contacts</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="navi-item">--}}
{{--                            <a href="#" class="navi-link">--}}
{{--                                                    <span class="navi-icon">--}}
{{--                                                        <i class="flaticon2-rocket-1"></i>--}}
{{--                                                    </span>--}}
{{--                                <span class="navi-text">Groups</span>--}}
{{--                                <span class="navi-link-badge">--}}
{{--                                                        <span class="label label-light-primary label-inline font-weight-bold">new</span>--}}
{{--                                                    </span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="navi-item">--}}
{{--                            <a href="#" class="navi-link">--}}
{{--                                                    <span class="navi-icon">--}}
{{--                                                        <i class="flaticon2-bell-2"></i>--}}
{{--                                                    </span>--}}
{{--                                <span class="navi-text">Calls</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="navi-item">--}}
{{--                            <a href="#" class="navi-link">--}}
{{--                                                    <span class="navi-icon">--}}
{{--                                                        <i class="flaticon2-gear"></i>--}}
{{--                                                    </span>--}}
{{--                                <span class="navi-text">Settings</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="navi-separator my-3"></li>--}}
{{--                        <li class="navi-item">--}}
{{--                            <a href="#" class="navi-link">--}}
{{--                                                    <span class="navi-icon">--}}
{{--                                                        <i class="flaticon2-magnifier-tool"></i>--}}
{{--                                                    </span>--}}
{{--                                <span class="navi-text">Help</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="navi-item">--}}
{{--                            <a href="#" class="navi-link">--}}
{{--                                                    <span class="navi-icon">--}}
{{--                                                        <i class="flaticon2-bell-2"></i>--}}
{{--                                                    </span>--}}
{{--                                <span class="navi-text">Privacy</span>--}}
{{--                                <span class="navi-link-badge">--}}
{{--                                                        <span--}}
{{--                                                            class="label label-light-danger label-rounded font-weight-bold">5</span>--}}
{{--                                                    </span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                    <!--end::Navigation-->--}}
{{--                </div>--}}
{{--                <!--end::Dropdown-->--}}
{{--            </div>--}}

            <div class="dropdown">
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-dropdown btn-lg mr-1 pulse pulse-white">
                            <span class="svg-icon svg-icon-xl"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-09-15-014444/theme/html/demo7/dist/../src/media/svg/icons/Home/Earth.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="9"/>
                                        <path
                                            d="M11.7357634,20.9961946 C6.88740052,20.8563914 3,16.8821712 3,12 C3,11.9168367 3.00112797,11.8339369 3.00336944,11.751315 C3.66233009,11.8143341 4.85636818,11.9573854 4.91262842,12.4204038 C4.9904938,13.0609191 4.91262842,13.8615942 5.45804656,14.101772 C6.00346469,14.3419498 6.15931561,13.1409372 6.6267482,13.4612567 C7.09418079,13.7815761 8.34086797,14.0899175 8.34086797,14.6562185 C8.34086797,15.222396 8.10715168,16.1034596 8.34086797,16.2636193 C8.57458427,16.423779 9.5089688,17.54465 9.50920913,17.7048097 C9.50956962,17.8649694 9.83857487,18.6793513 9.74040201,18.9906563 C9.65905192,19.2487394 9.24857641,20.0501554 8.85059781,20.4145589 C9.75315358,20.7620621 10.7235846,20.9657742 11.7357634,20.9960544 L11.7357634,20.9961946 Z M8.28272988,3.80112099 C9.4158415,3.28656421 10.6744554,3 12,3 C15.5114513,3 18.5532143,5.01097452 20.0364482,7.94408274 C20.069657,8.72412177 20.0638332,9.39135321 20.2361262,9.6327358 C21.1131932,10.8600506 18.0995147,11.7043158 18.5573343,13.5605384 C18.7589671,14.3794892 16.5527814,14.1196773 16.0139722,14.886394 C15.4748026,15.6527403 14.1574598,15.137809 13.8520064,14.9904917 C13.546553,14.8431744 12.3766497,15.3341497 12.4789081,14.4995164 C12.5805657,13.664636 13.2922889,13.6156126 14.0555619,13.2719546 C14.8184743,12.928667 15.9189236,11.7871741 15.3781918,11.6380045 C12.8323064,10.9362407 11.963771,8.47852395 11.963771,8.47852395 C11.8110443,8.44901109 11.8493762,6.74109366 11.1883616,6.69207022 C10.5267462,6.64279981 10.170464,6.88841096 9.20435656,6.69207022 C8.23764828,6.49572949 8.44144409,5.85743687 8.2887174,4.48255778 C8.25453994,4.17415686 8.25619136,3.95717082 8.28272988,3.80112099 Z M20.9991771,11.8770357 C20.9997251,11.9179585 21,11.9589471 21,12 C21,16.9406923 17.0188468,20.9515364 12.0895088,20.9995641 C16.970233,20.9503326 20.9337111,16.888438 20.9991771,11.8770357 Z"
                                            fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                            </span>
                        <span class="pulse-ring"></span>
                    </div>
                </div>
                <!--end::Toggle-->
                <div class="dropdown dropdown-inline">
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="">
                        <!--begin::Naviigation-->
                        <ul class="navi">
                            <li class="navi-item mb-2 mt-2">
                                <a href="{{ url()->current() }}?lang=en" class="navi-link">
                                            <span class="symbol symbol-20 mr-3">
                                                <img src="{{asset('assets/media/svg/flags/226-united-states.svg')}}"
                                                     alt=""/>
                                            </span>
                                    <span class="navi-text">{{ __('main.english') }}</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="{{ url()->current() }}?lang=ar" class="navi-link">
                                            <span class="symbol symbol-20 mr-3">
                                                <img src="{{asset('assets/media/svg/flags/008-saudi-arabia.svg')}}"
                                                     alt=""/>
                                            </span>
                                    <span class="navi-text">{{ __('main.arabic')}}</span>
                                </a>
                            </li>
                        </ul>
                        <!--end::Naviigation-->
                    </div>
                </div>

            {{--                    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-md">--}}

            {{--                        --}}
            {{--                        <form>--}}
            {{--                            <!--begin::Header-->--}}
            {{--                            <div class="d-flex flex-column pt-12 bgi-no-repeat rounded-top" style="background-image: url(media/misc/bg-1.jpg)">--}}
            {{--                                <!--begin::Title-->--}}
            {{--                                <h4 class="d-flex flex-center rounded-top">--}}
            {{--                                    <span class="text-white">{{ __('main.choose_the_lang') }}</span>--}}
            {{--                                </h4>--}}
            {{--                                <!--end::Title-->--}}
            {{--                                <!--begin::Tabs-->--}}
            {{--                                <ul class="nav mt-3 px-8"">--}}

            {{--                                </ul>--}}
            {{--                                <!--end::Tabs-->--}}
            {{--                            </div>--}}

            {{--                            <!--end::Content-->--}}
            {{--                        </form>--}}
            {{--                    </div>--}}
            <!--end::Dropdown-->
            </div>

            <!--end::Create-->
            <!--begin::Quick Panel-->
       {{--      <div class="topbar-item mr-4">
                <div class="btn btn-icon btn-sm btn-clean btn-text-dark-75 btn-dropdown" id="kt_quick_panel_toggle">
                                        <span class="svg-icon svg-icon-lg">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
                                                    <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                                                    <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                                                    <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                </div>
            </div> --}}
            <!--end::Quick Actions-->
            <!--begin::Quick Actions-->
            <div class="topbar-item mr-4">
                <div class="btn btn-icon btn-sm btn-clean btn-text-dark-75" id="kt_quick_actions_toggle">
                                        <span class="svg-icon svg-icon-lg">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                                                    <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                </div>
            </div>
            <!--end::Quick panel-->
            <!--begin::User-->
            <div class="topbar-item mr-4">
                <div class="btn btn-icon btn-sm btn-clean btn-text-dark-75" id="kt_quick_user_toggle">
                                        <span class="svg-icon svg-icon-lg">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                 viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                </div>
            </div>
            <!--end::User-->
            <!--begin::Notifications-->
            <div class="topbar-item">
                <div class="btn btn-icon btn-sm btn-primary font-weight-bolder p-0" id="kt_quick_notifications_toggle">{{ auth()->user()->unreadNotifications->count() }}</div>
            </div>
            <!--end::Notifications-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->

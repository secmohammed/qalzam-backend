<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <meta charset="utf-8"/>
    <title>Penduline | Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('assets/css/pages/login/login-1.css?v=7.0.5') }}" rel="stylesheet" type="text/css"/>
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.5') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/css/style.bundle.css?v=7.0.5') }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('icon.png') }}"/>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="quick-panel-right demo-panel-right offcanvas-right header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto" style="background: url({{ asset('assets/pattern.png') }}) no-repeat #c01e85">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <!--begin::Aside header-->
                <a href="#" class="text-center mb-10">
                    <img src="{{ asset('assets/logo.svg') }}" style="width: 180px; margin-top: 25px"  alt=""/>
                </a>
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"></div>
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                @yield('content')
            </div>
            <!--end::Content body-->

            <!--begin::Content footer-->
            <div class="row">
                <div class="col-md-6 d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
                    <div class="text-primary font-weight-bolder font-size-lg mr-10">
                        <span class="mr-1">2020©</span>
                        <a href="https://joovlly.com" target="_blank" class="font-weight-bolder font-size-lg">Joovlly Co.</a>
                    </div>
                </div>
                <div class="d-flex justify-content-lg-end d-inline col-md-6">
                    <div>
                        <a href="#" class="text-primary font-weight-bolder font-size-lg">Terms</a>
                        <a href="#" class="text-primary ml-5 font-weight-bolder font-size-lg">About</a>
                        <a href="#" class="text-primary ml-5 font-weight-bolder font-size-lg">Contact Us</a>
                    </div>
                </div>
            </div>
            <!--end::Content footer-->

        </div>
        <!--end::Content footer-->
    </div>
    <!--end::Content-->
</div>
<!--end::Login-->

<!--end::Main-->
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = {"breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#6993FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1E9FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };</script>
<!--end::Global Config-->
<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.0.5') }}"></script>
<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.5') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js?v=7.0.5') }}"></script>
<!--end::Global Theme Bundle-->
</body>
<!--end::Body-->
</html>

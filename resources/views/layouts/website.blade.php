<!DOCTYPE html>
<html lang="{{GetLanguage()}}" dir="{{GetDirection()}}">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Lorem PugJs">
        <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
        <meta name="keywords" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Qalazm</title>
        <link rel="stylesheet" href="{{asset('assets/website/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/website/css/home.css')}}">
        <link rel="stylesheet" href="{{asset('assets/website/css/lc_lightbox.css')}}">
        <link rel="stylesheet" href="{{asset('assets/website/css/bootstrap-datepicker3.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/website/css/jquery-clockpicker.min.css')}}">
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&amp;display=swap" rel="stylesheet">
        @if(GetLanguage() === 'en')
            <link rel='stylesheet' href='{{asset('assets/website/css/home-ltr.css')}}'>
        @endif
        <link rel="icon" href="{{asset('assets/website/images/favicon.png')}}" type="image/png">
        <script src="{{asset('assets/website/js/jquery.js')}}"></script>
        <script src="{{asset('assets/website/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/website/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/website/js/grt-youtube-popup.js')}}"></script>
        <script src="{{asset('assets/website/js/slick.min.js')}}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8NHubyvyyoetQLg1DBaz0tyvrNlAfWyg&amp;callback=initMap&amp;libraries=&amp;v=weekly&amp;language=" defer></script>
        <script src="{{asset('assets/website/js/locations.js')}}"> </script>
        <script src="{{asset('assets/website/js/lc_lightbox.lite.js')}}"></script>
        <script src="{{asset('assets/website/js/lightslider.js')}}"></script>
        <script src="{{asset('assets/website/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('assets/website/js/bootstrap-clockpicker.min.js')}}"></script>
        <script src="{{asset('assets/website/js/plugin.js')}}"></script>

        @livewireStyles
        @stack('styles')
    </head>
    <body>
        @include('layouts.partials.website.header')
            @yield('content')
        @include('layouts.partials.website.footer')

        <script src="{{asset('assets/website/js/cart.js')}}"></script>
        @livewireScripts
        @stack('scripts')
        <script>
            Livewire.on('toaster', (message,type) =>{
                switch (type){
                    case 'success':
                        toastr.success(message);
                        break;
                    case 'error':
                        toastr.error(message);
                        break;
                    case 'warning':
                        toastr.warning(message);
                        break;
                    default :
                        toastr.info(message);
                        break;
                }
            })
            Livewire.on('deleteAddressConfirmation', (id) => {
                // alert(id)
                $("#delete-modal").modal('show')
            })
        </script>
    </body>
</html>

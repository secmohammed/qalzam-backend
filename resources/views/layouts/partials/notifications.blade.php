<!-- begin::Notifications Panel-->
<div id="kt_quick_notifications" class="offcanvas offcanvas-right p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between mb-10">
        <h3 class="font-weight-bold m-0">
            {{ __('main.notifications') }}
            <small class="text-muted font-size-sm ml-2">{{ auth()->user()->unreadNotifications->count() }}</small></h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_notifications_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
        <!--begin::Nav-->
        <div class="navi navi-icon-circle navi-spacer-x-0">
            @foreach (auth()->user()->unreadNotifications as $key => $notification)
                 <a href="{{ $notification->data['link'] }}" class="navi-item">
                    <div class="navi-link rounded">
                        <div class="symbol symbol-50 symbol-circle mr-3">
                             {{ __("main.notification") }} {{ $key + 1 }}
                        </div>
                        <div class="navi-text">
                            <div class="font-weight-bold font-size-lg"></div>
                            <div class="text-muted">{{ __("main.{$notification->data['message']}") .' ' . $notification->data['id']  }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Content-->
</div>
<!-- end::Notifications Panel-->

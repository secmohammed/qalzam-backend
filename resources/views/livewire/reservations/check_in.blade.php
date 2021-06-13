<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <!--begin::Card-->
    <div class="card card-custom gutter-b card-stretch">
        <!--begin::Body-->
        <div class="card-body pt-4">
            <!--begin::Toolbar-->
          
            <!--end::Toolbar-->
            <!--begin::User-->
            <div class="d-flex align-items-center mb-7">
                <!--begin::Title-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">{{ $reservation->user->name }}</a>
                    <span class="text-muted font-weight-bold">{{ $reservation->user->mobile }}</span>
                </div>
                <!--end::Title-->
            </div>
            <!--end::User-->
            <!--begin::Info-->
            <div class="mb-7">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-dark-75 font-weight-bolder mr-2">Branch:</span>
                    <a href="#" class="text-muted text-hover-primary">{{ $reservation->branch->name }}</a>
                </div>
                <div class="d-flex justify-content-between align-items-cente my-2">
                    <span class="text-dark-75 font-weight-bolder mr-2">Room:</span>
                    <a href="#" class="text-muted text-hover-primary">{{ $reservation->accommodation->name }}</a>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-dark-75 font-weight-bolder mr-2">Checkin :</span>
                    <span class="text-muted font-weight-bold">{{ $reservation->start_date }}</span>
                </div>
            </div>
            <!--end::Info-->
            <a href="#" class="btn btn-block btn-sm btn-light-primary font-weight-bolder text-uppercase py-4" wire:click.prevent="$emit('deleteReservation', {{ $reservation  }})">Checkout</a>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->
</div>
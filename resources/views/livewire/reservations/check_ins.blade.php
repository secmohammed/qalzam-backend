<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Todo-->
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
@foreach ($reservations as $reservation)
    
<livewire:reservation.check-in :reservation="$reservation" :wire:key="$reservation->id"/>
@endforeach          
            <!--end::Col-->
         
        </div>
        <!--end::Row-->

    </div>
</div>

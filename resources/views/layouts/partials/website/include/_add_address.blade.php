{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
<div class="modal fade" id="add-address" role="dialog">
    <livewire:add-address key="'address-form'"/>
    @push('scripts')
        <script>
            $("#completion").click(function (){
                let address_id = $('input[name="address_id"]:checked').val();
                let address = $('input[name="address_id"]:checked').data("address");
                let products = {!! \App\Common\Facades\Cart::getProductsToBeOrdered()!!}
                console.log(address)
                console.log(products)
            })
        </script>
    @endpush
</div>
<div class="modal fade" id="edit-address">
    <livewire:edit-adress
        key="'edit-address-form'"
    />
</div>

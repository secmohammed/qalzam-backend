{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
<div class="modal fade" id="add-address" role="dialog">
    <livewire:add-address key="'address-form'"/>
    @push('scripts')
        <script>
            $("#errorContainerAddress").hide();
            $("#addLocation").click(function (event){
                event.preventDefault();
                let name = $("input[name=addressName]").val();
                let landmark = $("input[name=addressLandmark]").val();
                let postal_code = $("input[name=addressPostalCode]").val();
                let location_id = $("input[name=addressLocationId]").val();
                let user_id = '{{auth()->id()}}';
                let _token   = $('meta[name="csrf-token"]').attr('content');
                let address_1 = `${landmark}, ${name} `;
                $.ajax({
                    url: "{!! route('addresses.store') !!}",
                    type:"POST",
                    data:{
                        name:name,
                        landmark:landmark,
                        postal_code:postal_code,
                        location_id:location_id,
                        user_id:user_id,
                        address_1:address_1,
                        default:1,
                        _token:_token
                    },
                    success:function(response){
                        window.location.reload();
                    },
                    error:function (response){
                        $("#addressErrors").empty();
                        $("#errorContainerAddress").show();
                        $.each(response.responseJSON.errors, function (key, item)
                        {
                            console.log(item)
                            $("#addressErrors").append("<li class='text-light m-2 font-weight-bold'>"+item+"</li>")
                        });
                    }
                });
            })
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

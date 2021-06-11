<div class="flex-row-fluid container-fluid  py-2 py-lg-6    mt-5">
    <div class="card card-custom card-stretch gutter-b">
        <div class="card-body">
    <div class="row ">
        <!--begin::Product-->

        @foreach ($products as $product)
        <div class="col-md-4 col-lg-12 col-xxl-4">
            <div class="card card-custom gutter-b card-stretch">
                <div class="card-body d-flex flex-column rounded bg-light justify-content-between">
                    <div class="text-center rounded mb-7">
                        <img src="{{ $product['image'] }}" class="mw-100 w-200px">
                    </div>
                    <div>
                        <h4 class="font-size-h5">
                            <a href="{{ route("products.show",$product["id"]) }}" class="text-dark-75 font-weight-bolder">{{ $product["name"] }}</a>
                        </h4>
                        <div class="d-flex justify-content-between">
                            <div class="font-size-h6 text-muted font-weight-bolder">{{ __("main.price") }}: {{ $product["price"] }}</div>
                            <div class="font-size-h6 text-muted font-weight-bolder float-right">{{ __("main.quantity") }}: {{ $product["quantity"]??0 }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!--end::Product-->

    </div>
</div>
</div>
</div>
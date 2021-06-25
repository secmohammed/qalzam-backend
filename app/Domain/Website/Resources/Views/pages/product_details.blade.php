@extends('layouts.website', ['headerClass' => 'header-inner', 'activeRoute' => ''])
@section('content')
<section class="list">
        <div class="container">
            <ul class="wizard">
                <li> <a href="{{route('website.home')}}">
                        الرئيسيه
                        <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                        </svg></a></li>
                <li> <a href="{{route('website.branches')}}">
                        القائمة
                        <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                        </svg></a></li>
                <li> <a href="{{route('website.branch', ['branch' => \App\Common\Facades\Branch::getChangeableBranch()->id ])}}">
                    {{\App\Common\Facades\Branch::getChangeableBranch()->name}}
                        <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
                        </svg></a></li>
                <li> {{$product->name}} </li>
            </ul>
            <livewire:product-details
                :product="$product"
                key="'product-details'"
            />
        </div>
</section>
<section class="informations">
                <div class="container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">وصف المنتج </a></li>
                        <li class="nav-item"><a class="nav-link" id="product-options-tab" data-toggle="tab" href="#product-options" role="tab" aria-controls="product-options" aria-selected="false">خيارات المنتج</a></li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <livewire:product-details-information
                :product="$product"
                        
                        />
                        <div class="tab-pane fade" id="product-options" role="tabpanel" aria-labelledby="product-options-tab">
                            <ul class="options">
                                @foreach($variations as $index => $variation)
                                    <li>
                                        <p>{{$variation->type->name}} </p> <span>{{priceFormatted($variation->branches->where('id', \App\Common\Facades\Branch::getChangeableBranch()->id)->first()->pivot->price)}}  {{__('website.riyals')}}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
        </section>

@endsection

@push('scripts')
<script>
       Livewire.emit('toggleWishlist')

</script>
@endpush

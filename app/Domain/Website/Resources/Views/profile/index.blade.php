@extends('layouts.website', ['headerClass' => 'header-inner', 'activeRoute' => ''])
@section('content')

<section class="profile">
    <div class="container">
      <ul class="wizard">
        <li> <a href="index.html">
             الرئيسيه
            <svg width="9" height="9" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
              <path d="M7.58102 4.72562L2.96341 0.108013C2.81055 -0.0396239 2.56695 -0.0353851 2.41931 0.117483C2.27528 0.266608 2.27528 0.503012 2.41931 0.652115L6.76487 4.99767L2.41931 9.34322C2.26908 9.49347 2.26908 9.73707 2.41931 9.88733C2.56959 10.0376 2.81316 10.0376 2.96341 9.88733L7.58102 5.26972C7.73125 5.11944 7.73125 4.87587 7.58102 4.72562Z"></path>
            </svg></a></li>
        <li> الصفحة الشخصية</li>
      </ul>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="profile-personly-tab" data-toggle="tab" href="#profile-personly" role="tab" aria-controls="profile-personly" aria-selected="true">الملف الشخصي</a></li>
        <li class="nav-item"><a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">العناوين</a></li>
        <li class="nav-item"><a class="nav-link" id="requests-tab" data-toggle="tab" href="#requests" role="tab" aria-controls="requests" aria-selected="false">طلباتي</a></li>
        <li class="nav-item"><a class="nav-link" id="favorite-tab" data-toggle="tab" href="#favorite" role="tab" aria-controls="favorite" aria-selected="false">المفضلة</a></li>
      </ul>
      <!--div.alert.alert-success
      svg(width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg")
        path(d="M39.2853 18.2363V20.0106C39.2829 24.1694 37.9363 28.2161 35.4461 31.547C32.956 34.8779 29.4559 37.3147 25.4678 38.4939C21.4796 39.673 17.2172 39.5314 13.3161 38.0902C9.41497 36.6489 6.08427 33.9852 3.82072 30.4964C1.55717 27.0075 0.482036 22.8805 0.755672 18.7307C1.02931 14.5809 2.63705 10.6307 5.33912 7.46926C8.04119 4.30784 11.6928 2.10457 15.7494 1.18804C19.8059 0.271518 24.0501 0.690841 27.8489 2.38348M39.2853 4.58207L19.9996 23.8871L14.2139 18.1014" stroke="white" stroke-linecap="round" stroke-linejoin="round")
      div.contant
       p تم التعديل بنجاح
      -->
  {{-- @dd(isSet($serverMemo)?$serverMemo:"") --}}

@include('layouts.partials.website.include._successMessage',['success_component'=>"user-success"])
@include('layouts.partials.website.include._errorMessage')
      <div class="tab-content" id="myTabContent">
        {{-- <livewire:profile.update-user/> --}}
        <livewire:profile.my-orders/>
        @include("{$alias}::profile.partials._addresses", ['addresses' => $user->addresses])
        @include("{$alias}::profile.partials._update-my-profile")
        @include('layouts.partials.website.profile.my_favourite')

      </div>
    </div>
  </section>
@push('scripts')
    <script>
        // Livewire.on('canNotBeAdd', product => {
        //     alert('THis Can not Be Added' + product.totalPrice)
        // })
    </script>
@endpush
@endsection

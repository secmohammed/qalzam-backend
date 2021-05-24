<div class="col-sm-3 selection">
    <label class="che-box">
        <input type="radio" name="address_id" value="{{$addressId}}" wire:model="selectedAddressId"><span class="label-text"></span>
        <div class="text-chek">
            <h4 class="title">{{$city}}، {{$district}}</h4>
            <p>{{$landmark}} , {{$streetName}}</p>
            <nav class="ac-link">
                <a href="#edit-address" data-toggle="modal" wire:click="editAddressForm({{$addressId}})"><img src="{{asset('assets/website/images/edit.svg')}}" alt="" title=""> تعديل</a>
                <a href="#delete" data-toggle="modal" wire:click="deleteAddress({{$addressId}})"><img src="{{asset('assets/website/images/delete.svg')}}" alt="" title=""> حذف</a>
            </nav>
        </div>
    </label>
</div>

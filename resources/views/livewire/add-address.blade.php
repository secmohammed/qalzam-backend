<div class="modal-dialog">
    <div class="modal-content add-ad">
        <div class="headtitle">
            <h3 class="title">إضافة عنوان جديد</h3>
            <button class="close" type="button" data-dismiss="modal">
                <svg width="8" height="8" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.66271 6.00002L11.8625 0.800231C12.0455 0.617161 12.0455 0.320349 11.8625 0.137303C11.6794 -0.0457441 11.3826 -0.0457675 11.1995 0.137303L5.99975 5.33709L0.799987 0.137303C0.616917 -0.0457675 0.320105 -0.0457675 0.137058 0.137303C-0.0459882 0.320373 -0.0460117 0.617185 0.137058 0.800231L5.33682 6L0.137058 11.1998C-0.0460117 11.3829 -0.0460117 11.6797 0.137058 11.8627C0.228582 11.9542 0.348558 12 0.468535 12C0.588511 12 0.708464 11.9542 0.800011 11.8627L5.99975 6.66295L11.1995 11.8627C11.291 11.9542 11.411 12 11.531 12C11.651 12 11.7709 11.9542 11.8625 11.8627C12.0455 11.6796 12.0455 11.3828 11.8625 11.1998L6.66271 6.00002Z" fill="#1A1919"></path>
                </svg>
            </button>
    </div>
            <form action="#" method="post" wire:submit.prevent="saveAddress">
                @if(count($errors) > 0)
                    <div class="alert alert-danger errorContainerAddress">
                    <svg width="30" height="36" viewBox="0 0 40 46" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
                    <path d="M30.3317 9.61971L31.7399 10.699C35.0394 13.2307 37.432 16.7611 38.5611 20.7637C39.6901 24.7664 39.4951 29.0267 38.005 32.9094C36.5149 36.7921 33.8097 40.0892 30.2927 42.3088C26.7757 44.5284 22.6355 45.5517 18.4894 45.226C14.3434 44.9003 10.4137 43.2431 7.28642 40.5016C4.15914 37.7601 2.00185 34.0812 1.13628 30.0134C0.270714 25.9457 0.743244 21.7071 2.4834 17.9299C4.22355 14.1526 7.1381 11.0391 10.7924 9.05358M20.4942 1.31382L20.7017 27.5582" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                    <div class="contant">
                        <p class="text-light">هناك خطأ ما , يرجى إعاده المحاولة</p>
                        <div class="addressErrors">
                            @error('name') <li class='text-light m-2 font-weight-bold'>{{$message}}</li> @enderror
                            @error('landmark') <li class='text-light m-2 font-weight-bold'>{{$message}}</li> @enderror
                            @error('location_id') <li class='text-light m-2 font-weight-bold'>{{$message}}</li> @enderror
                            @error('postal_code') <li class='text-light m-2 font-weight-bold'>{{$message}}</li> @enderror
                        </div>
                    </div>
                </div>
                @endif
                    <div class="field">
                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0)">
                            <path d="M3.78049 6.06472L0.0864105 2.37063C-0.0316992 2.24834 -0.0283081 2.05346 0.0939863 1.93535C0.213286 1.82013 0.40241 1.82013 0.521692 1.93535L3.99814 5.41179L7.47458 1.93535C7.59478 1.81517 7.78966 1.81517 7.90986 1.93535C8.03005 2.05557 8.03005 2.25043 7.90986 2.37063L4.21578 6.06472C4.09556 6.1849 3.9007 6.1849 3.78049 6.06472Z" fill="#252525"></path>
                        </g>
                    </svg>
                    <select class="form-control" id="chooseCity" wire:model="chosenCity" wire:change="change">
                        <option>إختر المدينة</option>
                        @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="field">
                        <input class="form-control" name="addressName" type="text" placeholder="إسم الشارع" value="" wire:model="name">
                    </div>
                    <div class="field">
                        <input class="form-control" name="addressLandmark" type="text" placeholder="رقم المبني" value="" wire:model="landmark">
                    </div>
                    <div class="field">
                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0)">
                            <path d="M3.78049 6.06472L0.0864105 2.37063C-0.0316992 2.24834 -0.0283081 2.05346 0.0939863 1.93535C0.213286 1.82013 0.40241 1.82013 0.521692 1.93535L3.99814 5.41179L7.47458 1.93535C7.59478 1.81517 7.78966 1.81517 7.90986 1.93535C8.03005 2.05557 8.03005 2.25043 7.90986 2.37063L4.21578 6.06472C4.09556 6.1849 3.9007 6.1849 3.78049 6.06472Z" fill="#252525"></path>
                        </g>
                    </svg>
                    <select class="form-control" name="addressLocationId" wire:model="location_id">
                        <option>إختر الحي</option>
                        @foreach($districts as $district)
                            <option value="{{$district->id}}">{{$district->name}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="field">
                        <input class="form-control" name="addressPostalCode" type="text" placeholder="الرمز البريدي" value="" wire:model="postal_code">
                    </div>
                    <div class="field">
                        <button class="bottom" type="submit">اضف الأن</button>
                    </div>
            </form>
    </div>
</div>


<div class="modal fade" id="delete-modal" role="dialog" wire:ignore>
    <div class="modal-dialog">
        <div class="modal-content login">
            <div class="headtitle">
                <h3 class="title">ازالة العنوان</h3>
                <button class="close" type="button" data-dismiss="modal">
                    <svg width="8" height="8" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.66271 6.00002L11.8625 0.800231C12.0455 0.617161 12.0455 0.320349 11.8625 0.137303C11.6794 -0.0457441 11.3826 -0.0457675 11.1995 0.137303L5.99975 5.33709L0.799987 0.137303C0.616917 -0.0457675 0.320105 -0.0457675 0.137058 0.137303C-0.0459882 0.320373 -0.0460117 0.617185 0.137058 0.800231L5.33682 6L0.137058 11.1998C-0.0460117 11.3829 -0.0460117 11.6797 0.137058 11.8627C0.228582 11.9542 0.348558 12 0.468535 12C0.588511 12 0.708464 11.9542 0.800011 11.8627L5.99975 6.66295L11.1995 11.8627C11.291 11.9542 11.411 12 11.531 12C11.651 12 11.7709 11.9542 11.8625 11.8627C12.0455 11.6796 12.0455 11.3828 11.8625 11.1998L6.66271 6.00002Z" fill="#1A1919"></path>
                    </svg>
                </button>
            </div>
            <p class="text"> هل انت متأكد من ازالة العنوان</p>
            <div class="field"><a class="bottom" href="#" wire:click="deleteAddress({{$address_id}})">نعم بالتأكيد</a></div>
        </div>
    </div>
</div>

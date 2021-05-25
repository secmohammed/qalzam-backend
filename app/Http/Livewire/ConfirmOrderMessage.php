<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ConfirmOrderMessage extends Component
{
    protected $listeners = ['selectedAddress' => 'confirmationMessage'];

    public function getMessageProperty()
    {
        return '';
    }

    public function render()
    {
        return view('livewire.confirm-order-message');
    }

    public function confirmationMessage($address,$is_address = true)
    {
        $this->message = 'New Message';
//        $this->withAddressDetails();
    }

    private function withAddressDetails()
    {
        $this->message = 'New Message';
//        $this->message = 'يرجي التأكيد، بأن طلبك من <span>فرع عابر  القارات</span> علي عنوان <span>جدة، الحي الأول، عمارة رقم ٣</span>';
    }

    private function withoutAddressDetails()
    {
    }
}

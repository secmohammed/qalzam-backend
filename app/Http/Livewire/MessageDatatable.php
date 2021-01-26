<?php

namespace App\Http\Livewire;

use App\Domain\Message\Entities\Message;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class MessageDatatable extends MainLivewire
{
    public function builder()
    {
        return Message::with('user');
    }

    public function columns()
    {
        return [
            Column::checkbox('messages.id')->label(__('main.select_all')),

            NumberColumn::name('messages.id')
                ->label(__('main.id')),
            Column::name('messages.title')
                ->label(__('main.title'))->filterable('messages.title'),
            Column::name('messages.type')
                ->label(__('main.type'))->filterable([
                'push_notification' => __('main.push_notification'),
                'sms' => __('main.sms'),
            ]),
            Column::name('user.name')
                ->label(__('main.user'))->filterable('user.name'),

            DateColumn::name('messages.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['messages.id'], function ($id) {
                return view("messages::message.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

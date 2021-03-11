<?php

namespace App\Http\Livewire;

use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class DeliveryOrderDatatable extends MainLivewire
{
    public function builder()
    {
        return Order::query()->with('branch');
    }

    public function columns()
    {
        return [
            Column::checkbox('order.id')->label(__('main.select_all')),

            NumberColumn::name('order.id')
                ->label(__('main.id')),

            // Column::name('users.name')
            //     ->label(__('main.user'))
            //     ->filterable($this->builder()->get()->pluck('user.name')->unique()),

            Column::name('branch.name')
                ->label(__('main.branch'))
                ->filterable($this->builder()->get()->pluck('branch.name')->unique()),
            DateColumn::name('order.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['order.id'], function ($id) {
                return view("orders::deliveryorder.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

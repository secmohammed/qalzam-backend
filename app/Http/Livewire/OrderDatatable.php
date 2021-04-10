<?php

namespace App\Http\Livewire;

use App\Domain\Order\Entities\Order;
use App\Http\Livewire\MainLivewire;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class OrderDatatable extends MainLivewire
{
    public $exportable = true;
    public function builder()
    {
        return Order::query()->with(['branch', 'address']);
    }

    public function columns()
    {

        return [
            Column::checkbox('orders.id')->label(__('main.select_all')),

            NumberColumn::name('orders.id')
                ->label(__('main.id')),

            Column::name('address.name')
                ->label(__('main.address'))
                ->filterable($this->builder()->get()->pluck('address.name')->unique()),
            Column::name('user.name')
                ->label(__('main.customer'))
                ->filterable($this->builder()->get()->pluck('user.name')->unique()),
            Column::name('orders.status')
                ->label(__('main.status'))
                ->filterable([
                    'pending' => __('main.pending'),
                    'processing' => __('main.processing'),
                    'picked' => __('main.picked'),
                    'delivered' => __('main.delivered'),

                ]),
            Column::name('branch.name')
                ->label(__('main.branch'))
                ->filterable($this->builder()->get()->pluck('branch.name')->unique()),

            DateColumn::name('orders.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['orders.id'], function ($id) {
                return view("orders::order.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

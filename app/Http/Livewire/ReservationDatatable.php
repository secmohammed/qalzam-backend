<?php

namespace App\Http\Livewire;

use App\Http\Livewire\MainLivewire;
use Mediconesystems\LivewireDatatables\Column;
use App\Domain\Reservation\Entities\Reservation;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ReservationDatatable extends MainLivewire
{
    public function builder()
    {
        return Reservation::query()->with(['accommodation', 'branch', 'user', 'creator']);
    }

    public function columns()
    {

        return [
            Column::checkbox('reservations.id')->label(__('main.select_all')),

            NumberColumn::name('reservations.id')
                ->label(__('main.id')),

            Column::name('accommodation.name')
                ->label(__('main.accommodation'))
                ->filterable($this->builder()->get()->pluck('accommodation.name')->unique()),
            Column::name('user.name')
                ->label(__('main.user'))
                ->filterable($this->builder()->get()->pluck('user.name')->unique()),
            Column::name('creator.name')
                ->label(__('main.creator'))
                ->filterable($this->builder()->get()->pluck('creator.name')->unique()),

            Column::name('branch.name')
                ->label(__('main.branch'))
                ->filterable($this->builder()->get()->pluck('branch.name')->unique()),

            Column::name('reservations.status')
                ->label(__('main.status'))
                ->filterable([
                    'upcoming' => __('main.upcoming'),
                    'done' => __('main.done'),
                ]),
            Column::name('reservations.price')
                ->label(__('main.price'))
                ->filterable(),

            DateColumn::name('reservations.start_date')
                ->label(__('main.start_date'))
                ->filterable('start_date')
                ->format('h:m:s Y-m-d'),
            DateColumn::name('reservations.end_date')
                ->label(__('main.end_date'))
                ->filterable('end_date')
                ->format('h:m:s Y-m-d'),

            DateColumn::name('reservations.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['reservations.id'], function ($id) {
                return view("reservations::reservation.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}
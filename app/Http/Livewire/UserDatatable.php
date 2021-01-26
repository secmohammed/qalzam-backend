<?php

namespace App\Http\Livewire;

use App\Domain\User\Entities\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class UserDatatable extends MainLivewire
{
    public function builder()
    {
        return User::query();
    }

    public function columns()
    {
        return [
            Column::checkbox('users.id')->label(__('main.select_all')),

            NumberColumn::name('users.id')
                ->label(__('main.id')),

            Column::name('users.name')
                ->label(__('main.name'))
                ->filterable('name'),

            Column::name('users.email')
                ->label(__('main.email'))
                ->filterable('email'),

            Column::name('users.status')
                ->label(__('main.status'))
                ->filterable([
                    'active' => __('main.active'),
                    'inactive' => __('main.inactive'),
                ]),

            DateColumn::name('users.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['users.id'], function ($id) {
                return view("users::user.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

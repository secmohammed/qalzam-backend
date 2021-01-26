<?php

namespace App\Http\Livewire;

use App\Domain\Store\Entities\Store;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserLocation;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class RoleDatatable extends MainLivewire
{
    public function columns()
    {
        return [
            Column::checkbox('roles.id')->label(__('main.select_all')),

            NumberColumn::name('roles.id')
                ->label(__('main.id')),

            Column::name('roles.name')
                ->label(__('main.name'))
                ->filterable('name'),

            DateColumn::name('roles.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['roles.id'], function ($id) {
                return view("users::role.buttons.actions", ['id' => $id]);
            })->label(__('main.actions'))
        ];
    }

    public function builder()
    {
        return Role::query();
    }
}

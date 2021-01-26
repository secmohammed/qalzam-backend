<?php

namespace App\Http\Livewire;

use App\Domain\Child\Entities\Child;
use App\Domain\Store\Entities\Store;
use App\Domain\User\Entities\Role;
use App\Domain\User\Entities\User;
use App\Domain\User\Entities\UserLocation;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ChildDatatable extends MainLivewire
{
    public function columns()
    {
        return [
            Column::checkbox('children.id')->label(__('main.select_all')),

            NumberColumn::name('children.id')
                ->label(__('main.id')),

            Column::name('children.name')
                ->label(__('main.name'))
                ->filterable('name'),

            DateColumn::name('children.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['children.id'], function ($id) {
                return view("childrens::child.buttons.actions", ['id' => $id]);
            })->label(__('main.actions'))
        ];
    }

    public function builder()
    {
        return Child::query();
    }
}

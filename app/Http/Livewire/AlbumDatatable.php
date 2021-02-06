<?php

namespace App\Http\Livewire;

use App\Domain\Branch\Entities\Album;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AlbumDatatable extends MainLivewire
{
    public function builder()
    {
        return Album::query()->with('branch');
    }

    public function columns()
    {
        return [
            Column::checkbox('albums.id')->label(__('main.select_all')),

            NumberColumn::name('albums.id')
                ->label(__('main.id')),
            Column::name('albums.name')
                ->label(__('main.name'))->filterable('albums.name'),
            Column::name('branch.name')
                ->label(__('main.name'))->filterable('branches.name'),

            DateColumn::name('albums.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['albums.id'], function ($id) {
                return view("branches::album.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

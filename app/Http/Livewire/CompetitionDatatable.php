<?php

namespace App\Http\Livewire;

use Mediconesystems\LivewireDatatables\Column;
use App\Domain\Competition\Entities\Competition;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CompetitionDatatable extends MainLivewire
{
    public function builder()
    {
        return Competition::query()->with('location');
    }

    public function columns()
    {
        return [
            Column::checkbox('competitions.id')->label(__('main.select_all')),

            NumberColumn::name('competitions.id')
                ->label(__('main.id')),

            Column::name('competitions.name')
                ->label(__('main.name'))
                ->filterable('name'),

            Column::name('competitions.min_age')
                ->label(__('main.min_age'))
                ->filterable('min_age'),

            Column::name('competitions.max_age')
                ->label(__('main.max_age'))
                ->filterable('max_age'),

            Column::name('competitions.gender')
                ->label(__('main.gender'))
                ->filterable([
                    'female' => __('main.female'),
                    'male' => __('main.male'),
                    'both' => __('main.both'),
                ]),
            Column::name('competitions.featured')->label(__('main.featured'))->filterable([
                'featured',
                'normal',
            ]),
            Column::name('location.name')->label(__('main.location'))->filterable('location.name'),
            Column::name('competitions.type')
                ->label(__('main.type'))
                ->filterable([
                    'check-in' => __('main.check-in'),
                    'video' => __('main.video'),
                    'image' => __('main.image'),
                ]),

            DateColumn::name('competitions.created_at')
                ->label(__('main.created_at'))
                ->format('h:m:s Y-m-d'),

            Column::callback(['competitions.id'], function ($id) {
                return view("competitions::competition.buttons.actions", ['id' => $id]);
            })->label(__('main.actions')),
        ];
    }
}

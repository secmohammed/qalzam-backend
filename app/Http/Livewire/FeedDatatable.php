<?php

namespace App\Http\Livewire;

use App\Domain\Doctor\Entities\Doctor;
use App\Domain\Feed\Entities\Feed;
use App\Domain\Post\Entities\Post;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class FeedDatatable extends MainLivewire
{
    public function builder()
    {
        return Feed::query()->with('competitions');
    }

    public function columns()
    {
        return [
            Column::checkbox()->label(__('main.select_all')),

                NumberColumn::name('id')
                    ->label(__('main.id')),

                Column::name('competitions.name')
                    ->label(__('main.competition'))
                    ->filterable($this->builder()->get()->pluck('competitions.name')->unique()),

                Column::name('feeds.status')
                    ->label(__('main.status'))
                    ->filterable([
                        'pending' => __('main.pending'),
                        'winner' => __('main.winner'),
                        'disqualified' => __('main.disqualified'),
                    ]),

                DateColumn::name('created_at')
                    ->label(__('main.created_at'))
                    ->format('h:m:s Y-m-d'),

                Column::callback(['id'], function ($id) {
                    return view("feeds::feed.buttons.actions", ['id' => $id]);
                })->label(__('main.actions')),
        ];
    }
}

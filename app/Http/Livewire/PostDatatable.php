<?php

namespace App\Http\Livewire;

use App\Domain\Doctor\Entities\Doctor;
use App\Domain\Post\Entities\Post;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class PostDatatable extends MainLivewire
{
    public function builder()
    {
        return Post::query();
    }

    public function columns()
    {
        return [
            Column::checkbox()->label(__('main.select_all')),

                NumberColumn::name('id')
                    ->label(__('main.id')),

                Column::name('title')
                    ->label(__('main.title'))
                    ->filterable('title'),

                Column::name('type')
                    ->label(__('main.type'))
                    ->filterable([
                        'featured' => __('main.featured'),
                        'normal' => __('main.normal'),
                    ]),

                Column::name('status')
                    ->label(__('main.status'))
                    ->filterable([
                        'approved' => __('main.approved'),
                        'disapproved' => __('main.disapproved'),
                    ]),

                DateColumn::name('created_at')
                    ->label(__('main.created_at'))
                    ->format('h:m:s Y-m-d'),

                Column::callback(['slug', 'id'], function ($slug, $id) {
                    return view("posts::post.buttons.actions", ['slug' => $slug, 'id' => $id]);
                })->label(__('main.actions')),
        ];
    }
}

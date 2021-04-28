<?php

namespace App\Domain\Ingredient\Datatables;

use App\Domain\Ingredient\Entities\Ingredient;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IngredientDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('status', function ($model){
                $color = $model->status == 'active' ? 'primary' : 'warning';
                return "<span class='badge badge-$color'>$model->status</span>";
            })
            ->editColumn('user.name', function ($model){
                $user = $model->user ? $model->user->name: '' ;
                return "<span>$user</span>";
            })
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('ingredients.show', ['ingredient' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('ingredients.edit', ['ingredient' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->rawColumns(['actions','user.name','status']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('ingredient-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-3' l><'col-6 text-right' B><'col-3' f>>
                                <'row'<'col-12' tr>>
                                <'row'<'col-5'i><'col-7 dataTables_pager'p>>")
            ->orderBy(1);
    }

    /**
     * Get query source of dataTable.
     * @param ingredient $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ingredient $model)
    {
        return $model->newQuery()->with(['user'])->select('ingredients.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ingredient_' . date('YmdHis');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title(__('main.id')),
            Column::make('name')->title(__('main.name')),
            Column::make('description')->title(__('main.description')),
            Column::make('user.name')->title(__('main.user')),
            Column::make('status')->title(__('main.status')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}

<?php

namespace App\Domain\Product\Datatables;

use App\Domain\Product\Entities\Product;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
            ->editColumn('user.name', function ($model){
                $user = $model->user ? $model->user->name: '' ;
                return "<span>$user</span>";
            })
            ->editColumn('status', function ($model){
                $color = $model->status == 'active' ? 'primary' : 'warning';
                return "<span class='badge badge-$color'>$model->status</span>";
            })
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('products.show', ['product' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('products.edit', ['product' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->rawColumns(['actions', 'user.name','status']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-3' l><'col-6 text-right' B><'col-3' f>>
                                <'row'<'col-12' tr>>
                                <'row'<'col-5'i><'col-7 dataTables_pager'p>>")
            ->orderBy(1);
    }

    /**
     * Get query source of dataTable.
     *
     * @param product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(product $model)
    {
        return $model->newQuery()->with(['user'])->select('products.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Product_' . date('YmdHis');
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
            Column::make('user.name')->title(__('main.user')),
            Column::make('slug')->title(__('main.slug')),
            Column::make('description')->title(__('main.description')),
            Column::make('price')->title(__('main.price')),
            Column::make('status')->title(__('main.status')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}

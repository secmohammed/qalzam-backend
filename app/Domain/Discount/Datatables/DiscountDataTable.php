<?php

namespace App\Domain\Discount\Datatables;

use App\Domain\Discount\Entities\discount;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DiscountDataTable extends DataTable
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
            ->editColumn('type', function ($model){
                $color = $model->type == 'amount' ? 'primary' : 'warning';
                return "<span class='badge badge-$color'>$model->type</span>";
            })
            ->editColumn('created_at' ,function ($model) {
                $created_at     = (new Carbon($model->created_at))->format('Y-m-d H:i');
                return "<span>$created_at</span>";
            })
            ->editColumn('checkbox', function ($model){
                return "<input type='checkbox' name='items[]' value='$model->id' id='selectResource'/>";
            })
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('discounts.show', ['discount' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('discounts.edit', ['discount' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->rawColumns(['status','checkbox','type','created_at','actions']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('discount-table')
            ->columns($this->getColumns())
            ->addCheckbox([],true)
            ->minifiedAjax()
            ->dom("<'row'<'col-3' l><'col-6 text-right' B><'col-3' f>>
            <'row'<'col-12' tr>>
            <'row'<'col-5'i><'col-7 dataTables_pager'p>>")
            ->orderBy(1);
    }

    /**
     * Get query source of dataTable.
     *
     * @param discount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(discount $model)
    {
        return $model->newQuery()->select('discounts.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'discount_' . date('YmdHis');
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
            Column::make('code')->title(__('main.code')),
            Column::make('number_of_usage')->title(__('main.number_of_usage')),
            Column::make('value')->title(__('main.value')),
            Column::make('type')->title(__('main.type')),
            Column::make('status')->title(__('main.status')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}

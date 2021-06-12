<?php

namespace App\Domain\Order\Datatables;

use App\Domain\Order\Entities\Order;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
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
            ->editColumn('creator.name', function ($model){
                $creator = $model->creator ? $model->creator->name: '' ;
                return "<span>$creator</span>";
            })
            ->editColumn('branch.name', function ($model){
                $branch = $model->branch ? $model->branch->name: '' ;
                return "<span>$branch</span>";
            })
            ->editColumn('address.name', function ($model){
                $address = $model->address ? $model->address->name: '' ;
                return "<span>$address</span>";
            })
            ->editColumn('subtotal', function ($model){
                $subtotal = $model->subtotal->amount();
                return "<span>$subtotal</span>";
            })
            ->editColumn('status', function ($model){
                $color =  $model->status == 'pending' ? 'primary' : ($model->status == 'processing' ? 'warning' : ($model->status == 'picked'? 'secondary' : 'success'));
                return "<span class='badge badge-$color'>$model->status</span>";
            })
            ->editColumn('created_at' ,function ($model) {
                $created_at     = (new Carbon($model->created_at))->format('Y-m-d H:i');
                return "<span>$created_at</span>";
            })
            ->editColumn('checkbox', function ($model){
                return "<input type='checkbox' name='items[]' value='$model->id' id='selectResource'/>";
            })
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('orders.show', ['order' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('orders.edit', ['order' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->rawColumns(['actions','checkbox','subtotal','status','address.name','branch.name', 'user.name', 'creator.name','created_at']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('order-table')
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
     * @param Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->newQuery()->with(['user','address','creator','branch'])->select('orders.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Order_' . date('YmdHis');
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
            Column::make('subtotal')->title(__('main.subtotal')),
            Column::make('status')->title(__('main.status')),
            Column::make('user.name')->title(__('main.user')),
            Column::make('creator.name')->title(__('main.creator')),
            Column::make('address.name')->title(__('main.address')),
            Column::make('branch.name')->title(__('main.branch')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}

<?php

namespace App\Domain\User\Datatables;

use App\Domain\User\Entities\Address;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AddressDataTable extends DataTable
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
            ->editColumn('location.name', function ($model){
                $location = $model->location ? $model->location->name: '' ;
                return "<span>$location</span>";
            })
            ->editColumn('status', function ($model){
                $color = $model->status == 'active' ? 'primary' : 'warning';
                return "<span class='badge badge-$color'>$model->status</span>";
            })
            ->editColumn('default', function ($model){
                $color = 'warning';
                $default = 'false';
                if($model->default)
                {
                    $color = 'primary';
                    $default = 'true';
                }
                return "<span class='badge badge-$color'>$default</span>";
            })
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('addresss.show', ['address' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('addresss.edit', ['address' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->rawColumns(['actions','default','status','user.name', 'location.name']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('address-table')
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
     * @param address $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(address $model)
    {
        return $model->newQuery()->with(['user','location'])->select('addresss.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Address_' . date('YmdHis');
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
            Column::make('address_1')->title(__('main.address')),
            Column::make('landmark')->title(__('main.landmark')),
            Column::make('location.name')->title(__('main.location')),
            Column::make('postal_code')->title(__('main.postal_code')),
            Column::make('status')->title(__('main.status')),
            Column::make('user.name')->title(__('main.user')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}

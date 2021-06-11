<?php

namespace App\Domain\Accommodation\Datatables;

use App\Domain\Accommodation\Entities\Contract;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContractDataTable extends DataTable
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
            ->addColumn('actions', function ($model) {
                $btn = "<a href=" . route('contracts.show', ['contract' => $model->id]) . " class='fa fa-eye text-primary mx-1'></a>";
                $btn = $btn . "<a href=" . route('contracts.edit', ['contract' => $model->id]) . " class='fa fa-edit text-primary mx-1'></a>";

                return $btn;
            })
            ->editColumn('template.name', function ($model){
                $template = $model->template ? $model->template->name: '' ;
                return "<span>$template</span>";
            })
            ->editColumn('user.name', function ($model){
                $user = $model->user ? $model->user->name: '' ;
                return "<span>$user</span>";
            })
            ->editColumn('status', function ($model){
                $color = $model->status == 'active' ? 'primary' : 'warning';
                return "<span class='badge badge-$color'>$model->status</span>";
            })
            ->editColumn('checkbox', function ($model){
                return "<input type='checkbox' name='items[]' value='$model->id' id='selectResource'/>";
            })
            ->editColumn('days', function ($model) {
                $days = implode(', ', $model->days);
                return "<span>$days</span>";
            })
            ->editColumn('created_at' ,function ($model) {
                $created_at     = (new Carbon($model->created_at))->format('Y-m-d H:i');
                return "<span>$created_at</span>";
            })
            ->rawColumns(['actions','checkbox','template.name','user.name','created_at', 'status', 'days']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('contract-table')
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
     * @param Contract $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contract $model)
    {
        return $model->newQuery()->with(['user', 'template'])->select('contracts.*');
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Contract_' . date('YmdHis');
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
            Column::make('template.name')->title(__('main.template')),
            Column::make('user.name')->title(__('main.user')),
            Column::make('days')->title(__('main.days')),
            Column::make('status')->title(__('main.status')),
            Column::make('created_at')->title(__('main.created_at')),
            Column::computed('actions')->title(__('main.actions')),
        ];
    }
}
